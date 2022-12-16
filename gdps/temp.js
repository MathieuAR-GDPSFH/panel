const Http = new XMLHttpRequest();

const url = 'http://127.0.0.1:30458/page/gdps/management?gdps_id=1';
Http.open("GET", url);
Http.send();

Http.onreadystatechange = (e) => {
    console.log(Http.responseText)
}