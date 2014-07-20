<div style="height:600px;position:relative;" id="game_wrap">
	<div id="game_carac" style="position:absolute;">
		<?php
			echo $this->Html->image('game_sprite.png', array('id' => "game_carac_img",));
		?>
	</div>
    <canvas id="myCanvas" style="position:absolute;">
        Your browser does not support the HTML5 canvas tag.
    </canvas>
</div>
<style>

*::selection 
{
    background-color:transparent;
}
</style>
<script>
    var type = 0;
    var last = 0;
    var wayOn = true;
    var pos = 0;
    var personnage = 0;
    var circleX = 0;
    var circleY = 0;
    var aBasicMap = new Array();
    function SpriteType(id){
        this.id = id;
        this.getId = function(){
            return this.id;
        }
        this.getColor = function(){
            switch(this.id){
                case 0 :
                    return '#000';
                break;
                case 1 :
                    return '#222';
                break;
                case 2 :
                    return '#444';
                break;
                case 3 :
                    return '#666';
                break;
                case 4 :
                    return '#888';
                break;
            }
        };
    }
    function Sprite(x,y,SpriteType){
        this.x = x;
        this.y = y;
        this.SpriteType = SpriteType;

        this.getX = function(){
            return this.x;
        };

        this.getY = function(){
            return this.y;
        };

        this.getType = function(){
            return this.SpriteType;
        };

        this.displayItem = function(){
            ctx.fillStyle=this.SpriteType.getColor();
            ctx.fillRect(this.x,this.y,32,32);
        };
    }

    function populateMap(){
        aBasicMap = new Array();
        var iHeight = 600;
        var iWidth = $('#game_wrap').width();
        var iSize = 32;
        var iXLine = parseInt(iWidth/iSize);
        var iYLine = parseInt(iHeight/iSize);
        for (var i = 0; i < iXLine; i++) {
            for (var j = 0; j < iYLine; j++) {
                var oSprite = new Sprite(i*32,j*32,new SpriteType(Math.floor((Math.random() * 4))));
                oSprite.displayItem();
                aBasicMap.push(oSprite);
            }
        }
    }

    function moveCircle(direction, X, Y){
        var circleXT = X;
        var circleYT = Y;
        var interval = setInterval(function(){
            ctx.clearRect(circleXT,circleYT,4,4);
            // ctx.canvas.width = ctx.canvas.width;
            switch (direction) {
                case 38:
                    circleYT = circleYT - 2;
                    break;
                case 39:
                    circleXT = circleXT + 2;
                    break;
                case 40:
                    circleYT = circleYT + 2;
                    break;
                case 37:
                    circleXT = circleXT - 2;
                    break;
            }
            ctx.fillStyle="#FF0000";
            ctx.fillRect(circleXT,circleYT,4,4);
        },5);
        setTimeout(function(){clearInterval(interval);ctx.canvas.width = ctx.canvas.width;},3000);
    }

	$('#game_carac_img').css('margin-left',parseInt(personnage*-96)+'px');
	$('#game_carac_img').css('margin-top','0px');

    var c=document.getElementById("myCanvas");
    var ctx=c.getContext("2d");
    ctx.canvas.width = $('#game_wrap').width();
    ctx.canvas.height = 600;
	$('#game_carac').width(32);
	$('#game_carac').height(32);
	$('#game_carac').css('overflow','hidden');
	$('#game_carac_img').css('max-width','none');
    //POPULATE MAP
    setInterval(function(){populateMap()},30);
    $('html').click(function(e){
            e.preventDefault();
            var offset = $('#game_carac').position();
            circleX = offset.left;
            circleY = offset.top;
            switch (last) {
                case 38:
                    circleX = circleX + 16;
                    break;
                case 39:
                    circleY = circleY + 16;
                    circleX = circleX + 32;
                    break;
                case 40:
                    circleY = circleY + 32;
                    circleX = circleX + 16;
                    break;
                case 37:
                    circleY = circleY + 16;
                    break;
            }
            moveCircle(last,circleX,circleY);
    });
    $('html').mousemove(function(e){
        e.preventDefault();
        var offset = $('#game_carac').position();
        circleX = offset.left;
        circleY = offset.top;
        var mouseX = e.offsetX;
        var mouseY = e.offsetY;
        var diffX = circleX - mouseX;
        var diffY = circleY - mouseY;
        var compX = Math.abs(diffX/circleX);
        var compY = Math.abs(diffY/circleY);
        if(compX > compY){
            if(diffX < 0 && last != 39){
                last = 39;
                pos = 0;
                wayOn = true;
                $('#game_carac_img').css('margin-left',parseInt(personnage*-96)+'px');
                $('#game_carac_img').css('margin-top','-64px');
            }else if (diffX > 0 && last != 37){
                last = 37;
                pos = 0;
                wayOn = true;
                $('#game_carac_img').css('margin-left',parseInt(personnage*-96)+'px');
                $('#game_carac_img').css('margin-top','-32px');
            }
        }else{
            if(diffY < 0 && last != 40){
                last = 40;
                pos = 0;
                wayOn = true;
                $('#game_carac_img').css('margin-left',parseInt(personnage*-96)+'px');
                $('#game_carac_img').css('margin-top','0px');
            }else if (diffY > 0 && last != 38){
                last = 38;
                pos = 0;
                wayOn = true;
                $('#game_carac_img').css('margin-left',parseInt(personnage*-96)+'px');
                $('#game_carac_img').css('margin-top','-96px');
            }
        }
    });

	$('html').keydown(function(e){
        if(e.keyCode == 32){
            e.preventDefault();
            var offset = $('#game_carac').position();
            circleX = offset.left;
            circleY = offset.top;
            switch (last) {
                case 38:
                    circleX = circleX + 16;
                    break;
                case 39:
                    circleY = circleY + 16;
                    circleX = circleX + 32;
                    break;
                case 40:
                    circleY = circleY + 32;
                    circleX = circleX + 16;
                    break;
                case 37:
                    circleY = circleY + 16;
                    break;
            }
            // clearInterval(interval);
            // ctx.canvas.width = ctx.canvas.width;
            // clearTimeout(timeOut);
            moveCircle(last,circleX,circleY);
        }
		//RIGHT
       	else if(e.keyCode == 39){
       		e.preventDefault();
       		if(last != e.keyCode){
       			last = e.keyCode;
       			pos = 0;
       			wayOn = true;
				$('#game_carac_img').css('margin-left',parseInt(personnage*-96)+'px');
				$('#game_carac_img').css('margin-top','-64px');
       		}
       		if(pos >= 2 && wayOn == true){
       			wayOn = false;
       		}
       		if(pos <= 0 && wayOn == false){
       			wayOn = true;
       		}
       		switch (pos) {
			    case 0:
					$('#game_carac_img').css('margin-left',parseInt(personnage*-96+0)+'px');
			        break;
			    case 1:
					$('#game_carac_img').css('margin-left',parseInt(personnage*-96-32)+'px');
			        break;
			    case 2:
					$('#game_carac_img').css('margin-left',parseInt(personnage*-96-64)+'px');
			        break;
		    }
       		if(wayOn == true){
		   		pos++;
       		}else{
		    	pos--;
       		}
       		var offset = $('#game_carac').offset();
       		$('#game_carac').offset({left: offset.left+32});
   		//UP
       	}else if(e.keyCode == 38){
       		e.preventDefault();
       		if(last != e.keyCode){
       			last = e.keyCode;
       			pos = 0;
       			wayOn = true;
				$('#game_carac_img').css('margin-left',parseInt(personnage*-96)+'px');
				$('#game_carac_img').css('margin-top','-96px');
       		}
       		if(pos >= 2 && wayOn == true){
       			wayOn = false;
       		}
       		if(pos <= 0 && wayOn == false){
       			wayOn = true;
       		}
       		switch (pos) {
			    case 0:
					$('#game_carac_img').css('margin-left',parseInt(personnage*-96+0)+'px');
			        break;
			    case 1:
					$('#game_carac_img').css('margin-left',parseInt(personnage*-96-32)+'px');
			        break;
			    case 2:
					$('#game_carac_img').css('margin-left',parseInt(personnage*-96-64)+'px');
			        break;
		    }
       		if(wayOn == true){
		   		pos++;
       		}else{
		    	pos--;
       		}
       		var offset = $('#game_carac').offset();
       		$('#game_carac').offset({top: offset.top-32});
       	//DOWN
       	}else if(e.keyCode == 40){
			e.preventDefault();
       		if(last != e.keyCode){
       			last = e.keyCode;
       			pos = 0;
       			wayOn = true;
				$('#game_carac_img').css('margin-left',parseInt(personnage*-96)+'px');
				$('#game_carac_img').css('margin-top','0px');
       		}
       		if(pos >= 2 && wayOn == true){
       			wayOn = false;
       		}
       		if(pos <= 0 && wayOn == false){
       			wayOn = true;
       		}
       		switch (pos) {
			    case 0:
					$('#game_carac_img').css('margin-left',parseInt(personnage*-96+0)+'px');
			        break;
			    case 1:
					$('#game_carac_img').css('margin-left',parseInt(personnage*-96-32)+'px');
			        break;
			    case 2:
					$('#game_carac_img').css('margin-left',parseInt(personnage*-96-64)+'px');
			        break;
		    }
       		if(wayOn == true){
		   		pos++;
       		}else{
		    	pos--;
       		}
       		var offset = $('#game_carac').offset();
       		$('#game_carac').offset({top: offset.top+32});
       	//LEFT
       	}else if(e.keyCode == 37){
       		e.preventDefault();
       		if(last != e.keyCode){
       			last = e.keyCode;
       			pos = 0;
       			wayOn = true;
				$('#game_carac_img').css('margin-left',parseInt(personnage*-96)+'px');
				$('#game_carac_img').css('margin-top','-32px');
       		}
       		if(pos >= 2 && wayOn == true){
       			wayOn = false;
       		}
       		if(pos <= 0 && wayOn == false){
       			wayOn = true;
       		}
       		switch (pos) {
			    case 0:
					$('#game_carac_img').css('margin-left',parseInt(personnage*-96+0)+'px');
			        break;
			    case 1:
					$('#game_carac_img').css('margin-left',parseInt(personnage*-96-32)+'px');
			        break;
			    case 2:
					$('#game_carac_img').css('margin-left',parseInt(personnage*-96-64)+'px');
			        break;
		    }
       		if(wayOn == true){
		   		pos++;
       		}else{
		    	pos--;
       		}
       		var offset = $('#game_carac').offset();
       		$('#game_carac').offset({left: offset.left-32});
       	}
    });
</script>