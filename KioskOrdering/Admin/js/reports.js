var modalbtn = document.querySelectorAll('.preview');

modalbtn.forEach(function(btn) {
    btn.onclick = function() {
        var modal = btn.getAttribute('data-modal');

        document.getElementById(modal).style.display = "block";
    };

});


var closebtn = document.querySelectorAll('.close');

closebtn.forEach(function(btn) {
    btn.onclick = function() {
        var modal = (btn.closest('.modalprev').style.display = "none");
    };
});

function prints() {
    window.print();
}

//-----------//

$(function() {
    $("#foodcategory").change(function(e) {
        var value = $('#foodcategory').val()
        console.log(value)
        $.ajax({
            url: "../json/bestSellersRateAPI.php?cat=" + value,
            cache: false,
            method: "GET",
            success: function(e) {
                // console.log(e)

                var bestsellers = JSON.parse(e)
                    // console.log(bestsellers)

                var bestsellershtml = bestsellers.map(function(v) {
                    // console.log(v["Name"])

                    return `
                    <tr>
                                <td>${v.FoodID}</td>
                                <td>${v.Name}</td>
                                <td>${v.TotalSold}</td>
                            </tr>
                    `


                })
                console.log(bestsellershtml)
                $("tbody").html(bestsellershtml)
            }
        })
    })
})


//---------//
$.ajax({
    url: "../json/totalOrdersMade.php",
    cache: false,
    method: "GET",
    success: function(e) {
        //  console.log(e)
        var totalorders = JSON.parse(e)
            // console.log(totalorders[0].TotalOrdersMade)
        $(".ordernum1").text(totalorders[0].TotalOrdersMade)

    }
})

$.ajax({
    url: "../json/bestSellersRateAPI.php?cat=Pizza",
    cache: false,
    method: "GET",
    success: function(e) {
        // console.log(e)

        var bestsellers = JSON.parse(e)
            // console.log(bestsellers)

        var bestsellershtml = bestsellers.map(function(v) {
                // console.log(v["Name"])

                return `
            <tr>
                        <td>${v.FoodID}</td>
                        <td>${v.Name}</td>
                        <td>${v.TotalSold}</td>
                    </tr>
            `


            })
            // console.log(bestsellershtml)
        $("tbody").html(bestsellershtml)
    }
})

$.ajax({
    url: "../json/paymentMethodRateAPI.php",
    cache: false,
    method: "GET",
    success: function(e) {
        // console.log(e)
        var paymeth = JSON.parse(e)
            // console.log(paymeth)
        var cash = (paymeth[0].PaymentMethodCount)
        var gcash = (paymeth[1].PaymentMethodCount)


        var earning = document.getElementById('earning').getContext('2d');
        var myChart1 = new Chart(earning, {
            type: 'doughnut',
            data: {
                labels: ['Cash', 'GCash'],
                datasets: [{
                    label: '# of Votes',
                    data: [cash, gcash],
                    backgroundColor: [
                        'rgba(34,209,31)',
                        'rgba(0, 56, 255)'
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {

                responsive: true

            }
        });

    }
})

//average user load//
var custno = document.getElementById('custno').getContext('2d');
var myChart = new Chart(custno, {
    type: 'line',
    data: {
        labels: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"],
        datasets: [{
            label: 'Current of User',
            data: [],
            backgroundColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(244, 159, 164, 1)',
            ],
            borderColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(244, 159, 164, 0.2)',
            ],
            borderWidth: 4
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});

$.ajax({
    url: "../json/averageUserLoadAPI.php?opt=This Week",
    cache: false,
    method: "GET",
    success: function(e) {
        let data = JSON.parse(e);
        let days = data.map(v => v.day);
        let counts = data.map(v => v.count);

        myChart.data.labels = days;
        myChart.data.datasets.forEach(dataset => {
            dataset.data = counts;
        });
        myChart.update();
    }
});

$('#weeks').on('change', function() {
    let value = $(this).val();
    $.ajax({
        url: `../json/averageUserLoadAPI.php?opt=${value}`,
        cache: false,
        method: "GET",
        success: function(e) {
            let data = JSON.parse(e);
            let days = data.map(v => v.day);
            let counts = data.map(v => v.count);

            myChart.data.labels = days;
            myChart.data.datasets.forEach(dataset => {
                dataset.data = counts;
            });
            myChart.update();
        }
    });
});
    
document.title = "Reports";