<script>
    var start = new Date;
    start.setHours(23, 59, 59); 
    
    // Update the count down every 1 second
    var x = setInterval(function() {
        var now = new Date().getTime();    
        var distance = Math.round((start - now) / 1000) * 1000;
        //var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        //days = "0" + days;
        if(hours < 10){
            hours = "0" + hours;
        }
        if(minutes < 10){
            minutes = "0" + minutes;
        }
        if(seconds < 10){
            seconds = "0" + seconds;
        }
        if (document.getElementById("bw21--counter")){
            document.getElementById("bw21--hour").innerHTML = hours;
            document.getElementById("bw21--minute").innerHTML = minutes;
            document.getElementById("bw21--secunde").innerHTML = seconds;
        }                
    }, 1000); 
</script>	