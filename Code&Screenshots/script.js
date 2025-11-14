let runningTotal = 0;

function calculateBill() {
    const kiloliters = document.getElementById("kiloliters").value;
    let bill = 0;

    if (kiloliters <= 15) {
        bill = kiloliters * 2;
    } else if (kiloliters <= 35) {
        bill = 30 + (kiloliters - 15) * 5;
    } else {
        bill = 100 + 30 + (kiloliters - 35) * 10;
    }
    bill+=50;

    document.getElementById("bill").innerHTML = "The bill for this household is Rs." + bill;

    runningTotal += bill;
    document.getElementById("runningTotal").innerHTML = "The total bill so far is Rs." + runningTotal;
}