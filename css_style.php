<?php
/*** set the content type header ***/
/*** Without this header, it wont work ***/
header("Content-type: text/css");

?>

html, body, td, form {
    font-family: "Monaco", monospace, sans-serif;
}

td.low {
    color: green;
}

td.normal {
    color: black;
}

td.high {
    color: red;
}

.hidden_desc { 
    display: none; 
} 

.title-cell:hover .hidden_desc {
    display: block;
    border: solid blue;
    padding: 10px;
    border-radius: 10px;
}

hr {
    border-top: 3px solid #bbb;
    margin-top: 30px;
}

h1 {
    margin: 30px;
    text-align: center;
}

.new_task {
    margin: auto;
    width: fit-content;
}

.data_div {
    left: 50%;
    margin: auto;
    width: fit-content;
}

#button {
    float: right;
    box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
    border-radius: 0px;
    border: 0.5px solid grey;
}

label {
    display: inline-block;
    width: 100px;
    text-align: left;
    padding: 5px;
}​

#lb {
    text-align: right;
    background-color: red;
}

