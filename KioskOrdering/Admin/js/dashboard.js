//weekly sales chart//
var ctx = document.getElementById('myChart').getContext('2d');
var weeklysaleschart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: [],
        datasets: [{
            label: 'Weekly Earning',
            data: [],
            backgroundColor: [
                'rgba(255, 99, 132, 0.5)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(153, 102, 255, 0.5)',
                'rgba(255, 159, 64, 0.5)',
                'rgba(244, 159, 164, 0.5)',
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(244, 159, 164, 1)',
            ],
            borderWidth: 4
        }]
    },
    options: {
        responsive: true,
    }
});
setInterval(function() {
    $.ajax({
        url: "../json/weeklySalesAPI.php",
        cache: false,
        method: "GET",
        success: function(e) {
            var weekly = JSON.parse(e)
            console.log(weekly)
            var day = (weekly[0])
                //console.log(day)
            var sales = (weekly[1])
                //console.log(sales)
            weeklysaleschart.data.labels = day;
            weeklysaleschart.data.datasets.forEach(dataset => {
                dataset.data = sales
            });
            weeklysaleschart.update();
        }
    })
}, 1000)

//monthly sales chart//
var earning = document.getElementById('earning').getContext('2d');
var monthlysaleschart = new Chart(earning, {
    type: 'bar',
    data: {
        labels: [],
        datasets: [{
            label: 'Monthly Earning',
            data: [],
            backgroundColor: [
                'rgba(255, 99, 132, 0.5)',
                'rgba(54, 162, 235, 0.5)',
                'rgba(255, 206, 86, 0.5)',
                'rgba(75, 192, 192, 0.5)',
                'rgba(153, 102, 255, 0.5)',
                'rgba(255, 159, 64, 0.5)',
                'rgba(244, 159, 164, 0.5)',
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(244, 159, 164, 1)',
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true
    }
});


setInterval(function() {
    $.ajax({
        url: "../json/monthlySalesAPI.php",
        cache: false,
        method: "GET",
        success: function(e) {
            var monthly = JSON.parse(e)
            console.log(monthly)
            var month = (monthly[0])
                //console.log(day)
            var MSales = (monthly[1])
                //console.log(sales)
            monthlysaleschart.data.labels = month;
            monthlysaleschart.data.datasets.forEach(dataset => {
                dataset.data = MSales;
            });
            monthlysaleschart.update();
        }
    })
}, 1000)


// feed back//
var stats = document.getElementById('stats').getContext('2d');
var feedback = new Chart(stats, {
    type: 'polarArea',
    data: {
        labels: ['Bad', 'Good', 'Excellent'],
        datasets: [{
            data: [],
            backgroundColor: [
                'rgba(237,28,36, 0.5)',
                'rgba(255,247,0, 0.5)',
                'rgba(50,205,50, 0.5)',
            ],
        }]
    },
    options: {
        responsive: true
    }
});


setInterval(function() {
    $.ajax({
        url: "../json/feedbackRateAPI.php",
        cache: false,
        method: "GET",
        success: function(e) {
            var fdback = JSON.parse(e)
                // console.log(fdback)
            var good = (fdback[1].FeedbackCount)
            var fantastic = (fdback[2].FeedbackCount)
            var bad = (fdback[0].FeedbackCount)
            feedback.data.datasets.forEach(dataset => {
                dataset.data = [bad, fantastic, good]
            });
            feedback.update();
        }
    })
}, 1000)


//recent orders//
setInterval(function() {
    $.ajax({
        url: "../json/recentOrdersTableAPI.php",
        cache: false,
        method: "GET",
        success: function(e) {
            var orderhistory = JSON.parse(e);
                //console.log(orderhistory)
            var orderhistoryhtml = orderhistory.map(function(v) {
                    //  console.log(v["DatePaid"])
                    return `
                 <tr>
                    <td>${v.DatePaid}</td>
                    <td>${v.TableNo}</td>
                    <td>${v.PaymentMethod}</td>
                    <td>${v.TotalPrice}</td>
                  </tr>
                 `
                })
                //  console.log(orderhistoryhtml)
            $("tbody").html(orderhistoryhtml)
        }

    })
}, 1000)


// today sales //
setInterval(function() {
    $.ajax({
        url: "../json/todaysTotalSales.php",
        cache: false,
        method: "GET",
        success: function(e) {
            $("#TodaySales").text(e)
        }
    })
}, 1000)


// today served //
setInterval(function() {
    $.ajax({
        url: "../json/todaysServedAPI.php",
        cache: false,
        method: "GET",
        success: function(e) {
            $("#TodayServed").text(e)
        }
    })
}, 1000)


// AVE //
setInterval(function() {
    $.ajax({
        url: "../json/averageOrderValue.php",
        cache: false,
        method: "GET",
        success: function(e) {
            console.log(e)
            $("#AOValue").text(e)
        }
    })
}, 1000)


// yesterday sales //
setInterval(function() {
    $.ajax({
        url: "../json/yesterdaysSales.php",
        cache: false,
        method: "GET",
        success: function(e) {
            console.log(e)
            $("#YestSale").text(e)
        }
    })
}, 1000)
    
document.title = "Administrator's Dashboard";