
//timer
// Set the date we're counting down to
var countDownDate = new Date("Aug 28, 2020 23:37:25").getTime();
console.log(countDownDate);
// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();

  // Find the distance between now and the count down date
  var distance = countDownDate - now;

  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  // Output the result in an element with id="demo"
  document.getElementById("countdown").innerHTML = days + "d " + hours + "h "
  + minutes + "m " + seconds + "s ";

  // If the count down is over, write some text 
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("countdown").innerHTML = "EXPIRED";
}
}, 1000);


// if detech mobile 
function detectMob() {
      const toMatch = [
      /Android/i,
      /webOS/i,
      /iPhone/i,
      /iPad/i,
      /iPod/i,
      /BlackBerry/i,
      /Windows Phone/i
      ];

      return toMatch.some((toMatchItem) => {
        return navigator.userAgent.match(toMatchItem);
      });
    }
        //version on phone
        if(detectMob()){
          document.getElementById("headerforcomputer").style.display = "none";
          document.getElementById("headerforphone").style.display = "block";
          document.getElementById("searchforphone").style.display = "block";
          document.getElementById("bodyforcomputer").style.display = "none";
          document.getElementById("bodyforphone").style.display = "block";
          document.getElementById("footercomputer").style.display = "none";
          document.getElementById("footerphone").style.display = "block";
        }
        //version on desktop
        else{
          document.getElementById("headerforcomputer").style.display = "block";
          document.getElementById("headerforphone").style.display = "none";
          document.getElementById("searchforphone").style.display = "none";
          document.getElementById("bodyforcomputer").style.display = "block";
          document.getElementById("bodyforphone").style.display = "none";
          document.getElementById("footercomputer").style.display = "block";
          document.getElementById("footerphone").style.display = "none";
        }

