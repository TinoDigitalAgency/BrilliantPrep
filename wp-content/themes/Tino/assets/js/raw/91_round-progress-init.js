$(document).ready(function () {
    initCircle();
});

function initCircle() {
    $('.circle-progress').each(function () {
        var val = parseInt($(this).attr('data-pct'));
        var circle = $(this).find('.bar');
        // console.log(circle);
        // console.log(val);

        if (isNaN(val)) {
            val = 100;
        }
        else{
            var r = 72;
            var c = -452.16;

            if (val < 0) { val = 0;}
            if (val > 100) { val = 100;}

            var pct = ((100-val)/100)*c;

            circle.css({ strokeDashoffset: pct});

            // $(this).attr('data-pct',val);
        }
    })
}