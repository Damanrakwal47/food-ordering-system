var userClickedPattern=[];
var gamePattern=[];
var buttonColours=["red","blue","green","yellow"];
var level=0;
var keyCond=false;



$(".btn").click(function()
{
var userChosenColour=$(this).attr("id");
userClickedPattern.push(userChosenColour);
var audioADD2="./sounds/"+userChosenColour+".mp3";
playSound(audioADD2);
animatePress(userChosenColour);
checkAnswer(userClickedPattern.length-1);
});



function  nextSequence()
{
    userClickedPattern=[];
    level++;
    $("h1").text("Level "+level);
   var randomNum=Math.floor(Math.random()*4);
   var randomChosenColour=buttonColours[randomNum];
   gamePattern.push(randomChosenColour);
   $("#"+randomChosenColour).fadeOut(100).fadeIn(100);
   var audioADD="./sounds/"+randomChosenColour+".mp3";
   playSound(audioADD);
}




function  playSound(name)
{
    var audio=new Audio(name);
   audio.play();
}




function animatePress(currentColour)
{
    $("."+currentColour).addClass("pressed");
    setTimeout(function()
    {
        $("."+currentColour).removeClass("pressed");
    },100);
}

$(document).keydown(function()
{
    if(keyCond==false)
    {
    nextSequence();
    }
    keyCond=true;
})




function checkAnswer(currentLevel)
{
    if(userClickedPattern[currentLevel]==gamePattern[currentLevel])
    {
        console.log(true);
        if(userClickedPattern.length==gamePattern.length)
        {
            setTimeout(function(){
                nextSequence()
            },1000);
        }
    }
    else{
        console.log(false);
        var aud=new Audio("./sounds/wrong.mp3");
        aud.play();
        $("body").addClass("game-over");
        setTimeout(function(){
            $("body").removeClass("game-over");
        },200);
        $("h1").text("Game Over, Press Any Key to Restart");
            startOver();
    }
}




function startOver()
{
    gamePattern=[];
    level=0;
    keyCond=false;
}