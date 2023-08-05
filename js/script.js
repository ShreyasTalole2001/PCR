/* Clear the localstorage if the day is sunday */
if (new Date().getDay() == 7) {
    clearLocalStorage()
}




function reloadPage1() {
    location.reload();
}

function reloadPage() {
    location.reload();
}

function clearLocalStorage() {
    localStorage.clear()
    location.reload()
}

function storeDataInLocalStorage(symbol, date, time, pcr) {

    var localStorageDataArray = JSON.parse(localStorage.getItem("data")) || []

    let newObj = {
        symbol: symbol,
        date: date,
        time: time,
        pcr: pcr
    }

    localStorageDataArray.push(newObj)
    localStorage.setItem('data', JSON.stringify(localStorageDataArray));

    deleteTableRows()
    localStorageDataArray.forEach(function (arrayItem) {
        // console.log(arrayItem)
        addRowInTable(arrayItem.symbol, arrayItem.date, arrayItem.time, arrayItem.pcr)
    })

}

function deleteTableRows() {

    var tableHeaderRowCount = 1;
    var table = document.getElementById("pcr_table");
    var rowCount = table.rows.length;

    for (var i = tableHeaderRowCount; i < rowCount; i++) {
        table.deleteRow(tableHeaderRowCount);
    }

}

function addRowInTable(symbol, date, time, pcr) {

    var table = document.getElementById("pcr_table");

    var row = table.insertRow(1);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);

    cell1.innerHTML = symbol;
    cell2.innerHTML = date;
    cell3.innerHTML = time;
    cell4.innerHTML = pcr;

}


function PCR_calculations(data) {

    var spotPrice = data.records.underlyingValue
    var strikePrice = 0;
    var strikePricesArray = data.records.strikePrices
    var indexOfStrikePrice = 0;

    /* find the spot price by comparing strike price also find the index of spot price */
    for (var i = 0; i < strikePricesArray.length; i++) {
        if (spotPrice < strikePricesArray[i]) {
            lower_strikePrice = strikePricesArray[i - 1]

            if (spotPrice - lower_strikePrice < 25) {
                indexOfStrikePrice = i - 1
            } else {
                indexOfStrikePrice = i
            }
            strikePrice = strikePricesArray[indexOfStrikePrice]
            break
        }
    }

    var index_ITM = 0;
    var index_ATM = 0;
    var index_OTM = 0;

    /* This searches the Strike price in Filtered Array*/
    for (var i = 0; i < data.filtered.data.length; i++) {
        if (data.filtered.data[i].strikePrice === strikePrice) {
            index_ITM = i - 1;
            index_ATM = i;
            index_OTM = i + 1;

            break;
        }
    }

    /* Print the expirary date */
    document.getElementById("expiraryDate").innerHTML = data.filtered.data[index_ATM].expiryDate

    /* This is according to the formula of Website */
    var activeStrikeIndex = index_ATM;
    var start = activeStrikeIndex - 9;
    var end = activeStrikeIndex + 7;
    var PE_SumOfChangeInOpenInterest = 0;
    var CE_SumOfChangeInOpenInterest = 0;

    console.log("Strike s: " + data.filtered.data[start].strikePrice)
    console.log("Strike e: " + data.filtered.data[end].strikePrice)


    for (var i = start; i <= end; i++) {
        PE_SumOfChangeInOpenInterest += data.filtered.data[i].PE.changeinOpenInterest
        console.log(data.filtered.data[i].strikePrice + " " + data.filtered.data[i].PE.changeinOpenInterest);
        CE_SumOfChangeInOpenInterest += data.filtered.data[i].CE.changeinOpenInterest
    }

    var activeStrikePCR = PE_SumOfChangeInOpenInterest / CE_SumOfChangeInOpenInterest
    activeStrikePCR = activeStrikePCR.toFixed(2)

    console.log("Strike : " + data.filtered.data[index_ATM].strikePrice)
    console.log("PE = " + PE_SumOfChangeInOpenInterest + " " + "CE = " + CE_SumOfChangeInOpenInterest)

    /* Update the Active Strike on view */ 
    document.getElementById("activeStrike").innerHTML = data.filtered.data[index_ATM].strikePrice


    /* This populate the table */
    var date = new Date().toISOString().split('T')[0];
    var time = new Date().getHours() + ":" + new Date().getMinutes() + ":" + new Date().getSeconds();
    // addRowInTable("NIFTY", date, time, activeStrikePCR)
    storeDataInLocalStorage("NIFTY", date, time, activeStrikePCR)


}

function fetchData() {
    var xhr = new XMLHttpRequest();
    var url = 'phpScript.php'; // Replace with the actual URL of your PHP script

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = xhr.responseText;
            // console.log(response)
            // console.log(JSON.parse(response));
            var data = JSON.parse(response)
            PCR_calculations(data)


            // Handle the response as needed
        } else if (xhr.readyState === 4 && xhr.status !== 200) {
            console.log('Error occurred while fetching the URL.');
            // Handle the error
        }
    };

    xhr.open('GET', url, true);
    xhr.send();
}



/* Set time interval and clear previous */ 
function selectTimeInterval(timeInt) {
    let timeInterval = timeInt

    clearInterval(window.previousIntervalId)

    if (timeInterval == 1) {
        window.previousIntervalId = setInterval(fetchData, 60000)
    }else if(timeInterval == 3){
        window.previousIntervalId = setInterval(fetchData, 180000)
    }else if(timeInterval == 5){
        window.previousIntervalId = setInterval(fetchData, 300000)
    }else{
        window.previousIntervalId = setInterval(fetchData, 900000)
    }

    document.getElementById("currInterval").innerHTML = timeInterval + " Minutes"

}

// Call the fetchData function to initiate the AJAX request
fetchData()
selectTimeInterval(3)





