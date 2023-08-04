<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <style>
    #pcr {
      font-weight: 900;
    }
  </style>
  <title>Active Strike PCR</title>
</head>

<body>



  <div class="container" style="max-width: 600px;">
    <h3>Live PCR Data (Time interval 3 Minutes)</h3>
    <hr>
    <button onclick="clearLocalStorage()">Clear Data</button>
    <button onclick="reloadPage()">Fetch Current Data</button>
    <a >Expirary Date : <span id="expiraryDate"></span> </a>

    <hr>
    <table class="table table-dark table-striped" id="pcr_table">
      <thead>
        <tr>
          <th scope="col">SYMBOL</th>
          <th scope="col">Date (YY-MM-DD)</th>
          <th scope="col">Time</th>
          <th scope="col">PCR</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th scope="row"></th>
          <td id="date"></td>
          <td id="time"></td>
          <td id="pcr"></td>
        </tr>
      </tbody>
    </table>
  </div>


</body>




<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="./js/script.js"></script>



</html>