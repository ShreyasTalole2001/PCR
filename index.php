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

    button {
      margin-top: 5px;
    }

    #controllers {
      margin-top: 50px;
      position: fixed;
    }
  </style>
  <title>LIVE PCR DATA</title>
</head>

<body>


  <div class="container">
    <div class="row">
      <div class="col-sm-6">
        <div class="container" style="max-width: 600px;">

          <hr>
          <table class="table table-dark " id="pcr_table">
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

      </div>

      <div class="col-sm-6">

        <div id="controllers">
          <h3>Live PCR Data</h3>
          <hr>
          <button onclick="clearLocalStorage()">Clear Data</button>
          <button onclick="reloadPage()">Fetch Current Data</button>
          <button onclick="selectTimeInterval(1)">1 Minute</button>
          <button onclick="selectTimeInterval(3)">3 Minute</button>
          <button onclick="selectTimeInterval(5)">5 Minute</button>
          <button onclick="selectTimeInterval(15)">15 Minute</button>
          <hr>
          <p>Expirary Date : <span id="expiraryDate" style="color: red;"></span> <br>
            Current Interval : <span id="currInterval" style="color: red;"></span> <br>
            Active Strike : <span id="activeStrike" style="color: red;"></span>
          </p>


        </div>
      </div>
    </div>
  </div>





</body>




<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="./js/script.js"></script>



</html>