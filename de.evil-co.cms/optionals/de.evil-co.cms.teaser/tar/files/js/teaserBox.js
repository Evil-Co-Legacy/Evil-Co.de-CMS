var actualFrame = 0;
var slideShowTimeout;
var lock = false;

/**
 * Start slideshow with specific datas.
 * 
 * @param {Integer} start_frame First frame.
 * @param {Integer} end_frame	Last frame.
 * @param {Integer} delay 		Delay in milliseconds.
 */
function startSlideShow(start_frame, end_frame, delay) {
	this.slideShowTimeout = setTimeout(switchTeaser(start_frame,start_frame,end_frame, delay), delay);
}

function switchTeaser(frame, start_frame, end_frame, delay) {
    return (function() {

		if(this.lock != true) {
			
			this.lock = true;
			frame = actualFrame;

	        Effect.Fade('teaserBox_' + frame);
			document.getElementById("teaserNav_" + frame).className = 'teaserNav';
			changeCursor('wait', frame);
	        if (frame == end_frame) {
				nextFrame = start_frame;
			} else {
				nextFrame = (parseInt(frame)+1); // int must casted!
			}
	        this.slideShowTimeout = setTimeout("Effect.Appear('teaserBox_" + nextFrame + "');", 850);
			document.getElementById("teaserNav_" + nextFrame).className += ' containerHead activeTeaser';
			setTimeout("changeCursor('pointer', " + nextFrame + ");", 850*2);
	
			this.actualFrame = nextFrame;
			setTimeout(function () { disableEnableMouseOver(); },850*2);
			
			this.slideShowTimeout = setTimeout(switchTeaser(this.actualFrame, start_frame, end_frame, delay), delay + 850);
		}
    })
}

function showTeaser(frame) {
	
	// disable slideshow
	if(this.slideShowTimeout) {
		clearTimeout(this.slideShowTimeout);
	}

	if(frame != this.actualFrame && this.lock != true) {
		
		this.lock = true;
		
		changeCursor('wait', this.actualFrame);
        Effect.Fade('teaserBox_' + this.actualFrame);
		document.getElementById("teaserNav_" + this.actualFrame).className = 'teaserNav';
		changeCursor('wait', frame);
        setTimeout("Effect.Appear('teaserBox_" + frame + "');", 850);
		document.getElementById("teaserNav_" + frame).className += ' containerHead activeTeaser';
		setTimeout("changeCursor('pointer', " + frame + ");", 850*2);
		
		setTimeout(function () { disableEnableMouseOver(); },850*2);
		actualFrame = frame;
	}
}

function changeCursor(cursorType, frame) {
	document.getElementById("teaserBox_" + frame).getElementsByTagName('a')[0].style.cursor = cursorType;
	document.getElementById("teaserNav_" + frame).getElementsByTagName('a')[0].style.cursor = cursorType;
}

function disableEnableMouseOver() {
	if (this.lock == true) {
		this.lock = false;
	} else {
		this.lock = true;
	}
}

function getRandomTeaser(min, max) {
	if(min > max) {
		return(-1);
	}
	if(min == max) {
		return(min);
	}
	var r = parseInt(Math.random() * (max + 1));
	return(r + min <= max ? r + min : r);
}