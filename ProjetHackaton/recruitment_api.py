from fastapi import FastAPI, Depends, HTTPException
from sqlalchemy import create_engine, Column, Integer, String, Text, Enum, ForeignKey, DateTime
from sqlalchemy.orm import sessionmaker, Session, declarative_base
from datetime import datetime
import enum
from typing import Optional, List
from pydantic import BaseModel
from fastapi.middleware.cors import CORSMiddleware


DATABASE_URL = "mysql+pymysql://root:@localhost/hackathon"

engine = create_engine(DATABASE_URL)
SessionLocal = sessionmaker(autocommit=False, autoflush=False, bind=engine)
Base = declarative_base()

# Modèles SQLAlchemy
class Job(Base):
    __tablename__ = 'jobs'
    id = Column(Integer, primary_key=True, index=True)
    recruiter_id = Column(Integer, nullable=False)
    title = Column(String(255), nullable=False)
    description = Column(Text, nullable=False)
    location = Column(String(255))
    salary_range = Column(String(100))
    created_at = Column(DateTime, default=datetime.utcnow)

class ApplicationStatus(enum.Enum):
    pending = "pending"
    reviewed = "reviewed"
    accepted = "accepted"
    rejected = "rejected"

class Application(Base):
    __tablename__ = 'applications'
    id = Column(Integer, primary_key=True, index=True)
    job_id = Column(Integer, ForeignKey('jobs.id'))
    candidate_id = Column(Integer, nullable=False)
    candidate_name = Column(String(100), nullable=False)
    candidate_email = Column(String(100), nullable=True)
    candidate_phone = Column(String(50), nullable=True)
    status = Column(Enum(ApplicationStatus), default=ApplicationStatus.pending)
    cv_url = Column(String(255))
    cover_letter_url = Column(String(255))
    created_at = Column(DateTime, default=datetime.utcnow)

# Modèles Pydantic
class JobBase(BaseModel):
    recruiter_id: int
    title: str
    description: str
    location: Optional[str] = None
    salary_range: Optional[str] = None

class JobCreate(JobBase):
    pass

class JobRead(JobCreate):
    id: int
    created_at: datetime

    class Config:
        from_attributes = True

class ApplicationCreate(BaseModel):
    job_id: int
    candidate_id: int
    cv_url: Optional[str] = None
    cover_letter_url: Optional[str] = None

class ApplicationRead(BaseModel):
    id: int
    job_id: int
    candidate_id: Optional[int] = None
    candidate_name: str
    candidate_email: Optional[str] = None
    candidate_phone: Optional[str] = None
    status: ApplicationStatus
    cv_url: Optional[str] = None
    cover_letter_url: Optional[str] = None
    created_at: datetime

    class Config:
        from_attributes = True


app = FastAPI(title="Recruitment Platform API")

# 🔓 Origines autorisées
origins = [
    "http://localhost",
    "http://localhost:8000",  # ex: React/Vite front
    "http://127.0.0.1:5500",  # ex: Live Server
]

app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],  # tu peux affiner cela plus tard pour la sécurité
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)


# Dependency
def get_db():
    db = SessionLocal()
    try:
        yield db
    finally:
        db.close()

@app.get("/jobs", response_model=List[JobRead], tags=["jobs"])
def list_jobs(db: Session = Depends(get_db)):
    return db.query(Job).all()

@app.post("/jobs", response_model=JobRead, tags=["jobs"])
def create_job(job: JobCreate, db: Session = Depends(get_db)):
    db_job = Job(**job.dict())
    db.add(db_job)
    db.commit()
    db.refresh(db_job)
    return db_job

@app.get("/applications/{job_id}", response_model=List[ApplicationRead], tags=["applications"])

def list_applications(job_id: int, db: Session = Depends(get_db)):
    return db.query(Application).filter(Application.job_id == job_id).all()

@app.post("/applications", response_model=ApplicationCreate, tags=["applications"])
def apply(application: ApplicationCreate, db: Session = Depends(get_db)):
    db_application = Application(**application.dict())
    db.add(db_application)
    db.commit()
    db.refresh(db_application)
    return db_application



from fastapi import File, UploadFile, Form
import os

UPLOAD_DIR = "uploads"
os.makedirs(UPLOAD_DIR, exist_ok=True)

@app.post("/applications/upload", tags=["applications"])
async def upload_application(
    job_id: int = Form(...),
    candidate_name: str = Form(...),
    candidate_email: str = Form(None),
    candidate_phone: str = Form(None),
    cv: UploadFile = File(...),
    cover_letter: UploadFile = File(...),
    db: Session = Depends(get_db)
):
    cv_path = os.path.join(UPLOAD_DIR, cv.filename)
    cover_letter_path = os.path.join(UPLOAD_DIR, cover_letter.filename)

    with open(cv_path, "wb") as f:
        f.write(await cv.read())
    with open(cover_letter_path, "wb") as f:
        f.write(await cover_letter.read())

    application = Application(
        job_id=job_id,
        candidate_name=candidate_name,
        candidate_email=candidate_email,
        candidate_phone=candidate_phone,
        cv_url=cv_path,
        cover_letter_url=cover_letter_path
    )
    db.add(application)
    db.commit()
    db.refresh(application)
    return {"message": "Candidature enregistrée avec succès", "application_id": application.id}



from fastapi.staticfiles import StaticFiles
import os

# Servir le dossier 'frontend' qui contient les fichiers HTML
static_dir = os.path.join(os.path.dirname(__file__), "frontend")
os.makedirs(static_dir, exist_ok=True)  # on s'assure que le dossier existe

app.mount("/static", StaticFiles(directory=static_dir), name="static")

@app.put("/jobs/{job_id}", response_model=JobRead, tags=["jobs"])
def update_job(job_id: int, job: JobCreate, db: Session = Depends(get_db)):
    db_job = db.query(Job).filter(Job.id == job_id).first()
    if not db_job:
        raise HTTPException(status_code=404, detail="Offre non trouvée")
    for key, value in job.dict().items():
        setattr(db_job, key, value)
    db.commit()
    db.refresh(db_job)
    return db_job

@app.delete("/jobs/{job_id}", tags=["jobs"])
def delete_job(job_id: int, db: Session = Depends(get_db)):
    db_job = db.query(Job).filter(Job.id == job_id).first()
    if not db_job:
        raise HTTPException(status_code=404, detail="Offre non trouvée")
    db.delete(db_job)
    db.commit()
    return {"message": "Offre supprimée avec succès"}

from fastapi import Body

@app.put("/applications/{application_id}/status", tags=["applications"])
def update_application_status(
    application_id: int,
    payload: dict = Body(...),
    db: Session = Depends(get_db)
):
    status = payload.get("status")
    if status not in ApplicationStatus.__members__:
        raise HTTPException(status_code=400, detail="Statut invalide")
    
    application = db.query(Application).filter(Application.id == application_id).first()
    if not application:
        raise HTTPException(status_code=404, detail="Candidature non trouvée")

    application.status = ApplicationStatus[status]
    db.commit()
    db.refresh(application)
    return {"message": "Statut mis à jour avec succès", "application": application}

