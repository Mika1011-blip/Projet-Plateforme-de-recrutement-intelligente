import axios from 'axios';

export async function retrieve_data_db(){
    let db_data;
    axios.get('http://localhost/hackathon_ross_files/retrieve_data.php')
    .then(response => {
        //console.log("running retrive_data.js");
        //console.log(response.data.message);
        cdb_data = response.data;

        //console.log(cv_data);
    })
    .catch(error => {
        console.error(error);
        });
}

//retrieve_data_db();