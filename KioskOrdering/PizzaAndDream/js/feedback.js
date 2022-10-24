$(function(){

    let feed = "Good";
    
    let tableNo = $('#tableNo').val()
    
    const nStr = 'none Bad Good Fantastic'.split(' ')
    demo.textContent = nStr[ myRange.valueAsNumber ]
    myRange.oninput=_=>{
        demo.textContent = nStr[ myRange.valueAsNumber ];
        feed = demo.textContent
    }

    $('#exitFeedback').on('click', function(e){
        window.location.replace('../pages/index.php')
    });

    $('#btnDone').on('click', function(){
        $.ajax({
            url: '../php/FeedbackFunction.php',
            method: 'POST',
            data:{
                feedback: feed
            },
            success: function(e){
                window.location.replace('../pages/index.php?tbl=' + tableNo);
            }
        })
    });

});