// CONFIGS
const _luckyWheel = {}
// _luckyWheel.baseurl = 'http://localhost:3000/'
_luckyWheel.baseurl = 'http://wheel.nomadia.sk/'
_luckyWheel.css = `<style>
    #happy-wheel {
        position: fixed;
        top: 0;
        bottom: 0;
        left: -440px;
        width: 440px;
        z-index: 2001;
        background: #5454dd;
        transition: .3s left ease-in-out;

        padding: 100px 20px;
    }

    #happy-wheel.show {
        left: 0;
    }

    #overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: -2000;
        background-color: rgba(0, 0, 0, 0);
        transition: .3s background-color ease-in-out;
    }

    #overlay.show {
        z-index: 2000;
        background-color: rgba(0, 0, 0, .7);
    }

    #wheel-close {
        position: absolute;
        top: 15px;
        right: 15px;
        cursor: pointer;
    }
    
    .close-wrapper {
        width: 100vw;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .close-button {
        display: block;
        width: 40px;
        height: 40px;
        position: relative;
        overflow: hidden;
    }
    
    .close-button > div {
        position: relative;
    }
    
    .close-button-block {
        width: 40px;
        height: 20px;
        position: relative;
        overflow: hidden;
    }
    
    .close-button-block:before, .close-button-block:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: calc(55% - 4px);
        display: block;
        width: 4px;
        height: 25px;
        -webkit-transform-origin: bottom center;
        transform-origin: bottom center;
        background: white;
        transition: all ease-out 280ms;
    }
    
    .close-button-block:last-of-type {
        -webkit-transform: rotate(180deg);
        transform: rotate(180deg);
    }
    
    .close-button .in .close-button-block:before {
        transition-delay: 280ms;
        -webkit-transform: translateX(20px) translateY(-20px) rotate(45deg);
        transform: translateX(20px) translateY(-20px) rotate(45deg);
    }

    .close-button .in .close-button-block:after {
        transition-delay: 280ms;
        -webkit-transform: translateX(-22px) translateY(-22px) rotate(-45deg);
        transform: translateX(-22px) translateY(-22px) rotate(-45deg);
    }
    
    .close-button .out {
        position: absolute;
        top: 0;
        left: 0;
    }

    .close-button .out .close-button-block:before {
        -webkit-transform: translateX(-5px) translateY(5px) rotate(45deg);
        transform: translateX(-5px) translateY(5px) rotate(45deg);
    }

    .close-button .out .close-button-block:after {
        -webkit-transform: translateX(5px) translateY(5px) rotate(-45deg);
        transform: translateX(5px) translateY(5px) rotate(-45deg);
    }

    .close-button:hover .in .close-button-block:before {
        -webkit-transform: translateX(-5px) translateY(5px) rotate(45deg);
        transform: translateX(-5px) translateY(5px) rotate(45deg);
    }
    
    .close-button:hover .in .close-button-block:after {
        -webkit-transform: translateX(5px) translateY(5px) rotate(-45deg);
        transform: translateX(5px) translateY(5px) rotate(-45deg);
    }
    
    .close-button:hover .out .close-button-block:before {
        -webkit-transform: translateX(-20px) translateY(20px) rotate(45deg);
        transform: translateX(-20px) translateY(20px) rotate(45deg);
    }
    
    .close-button:hover .out .close-button-block:after {
        -webkit-transform: translateX(20px) translateY(20px) rotate(-45deg);
        transform: translateX(20px) translateY(20px) rotate(-45deg);
    }
    
    #wheel-mail {
        display: inline-block;
        margin: 0;
        padding: 12px 18px;
        color: inherit;
        width: calc(100% - 80px);
        font-family: inherit;
        font-size: 1em;
        font-weight: inherit;
        border: none;
        border-bottom-left-radius: 0.2rem;
        border-top-left-radius: 0.2rem;
        box-shadow: 0 0 .7rem rgba(0, 0, 0, .3);
        transition: box-shadow .3s ease-in-out;
    }

    #wheel-mail:focus {
        outline: none;
        box-shadow: 0 0 1rem rgba(0, 0, 0, .6);
    }

    #wheel-spin {
        background-color: #9ca3d6;
        display: inline-block;
        margin: 0;
        padding: 12px 18px;
        color: inherit;
        width: 80px;
        font-family: inherit;
        font-size: 1em;
        font-weight: bold;
        border: none;
        border-bottom-right-radius: 0.2rem;
        border-top-right-radius: 0.2rem;
        box-shadow: 0 0 .7rem rgba(0, 0, 0, .3);
        transition: box-shadow .3s ease-in-out;
    }
        
    @media (max-width: 575px) {
        #happy-wheel {
            width: 100%;
            left: -100%;
            text-align: center;
        }
        
        /* TODO: Fix the wheel push to left, not right on small screens */
        /*#happy-wheel.show canvas {*/
        /*    width: 400px;*/
        /*    position: relative;*/
        /*    right: 15px;*/
        /*}*/
    
        #form-mail.phoneKeyboard {
            position: absolute;
            width: calc(100% - 45px);
            bottom: 15px;
        }
    }
</style>`

_luckyWheel.spinId = undefined
_luckyWheel.hidePanel = () => {
    $('#happy-wheel').removeClass('show')
    $('#overlay').removeClass('show')
    window.cancelAnimationFrame(_luckyWheel.spinId)
    this.spinId = undefined
}
_luckyWheel.showPanel = () => {
    $('#happy-wheel').removeClass('show')
    $('#overlay').removeClass('show')
}

// HELPERS
// Helper for AJAX requests
_luckyWheel.ajaxRequest = (url, callback) => {
    let response;

    let xhr = new XMLHttpRequest();
    xhr.open('GET', _luckyWheel.baseurl + url);

    xhr.onload = () => {
        if (xhr.status === 200) {
            // Parse the response
            response = JSON.parse(xhr.responseText)
            callback(response)
        } else {
            // console.error('AJAX Request failed. Returned status of ' + xhr.status);
        }
    };

    xhr.send();
}

// Helper for encoding to hex
String.prototype.hexEncode = function () {
    var hex, i;

    var result = "";
    for (i = 0; i < this.length; i++) {
        hex = this.charCodeAt(i).toString(16);
        result += ("000" + hex).slice(-4);
    }

    return result
}

// WHEEL class
class Wheel {
    constructor(canvas, originalctx, prizes) {
        this.buffer = document.createElement('canvas')
        this.buffer.width = canvas.width
        this.buffer.height = canvas.height
        this.context = this.buffer.getContext('2d')

        this.angle = 0
        this.toAngle = 0
        this.speed = 0
        this.originalctx = originalctx

        // Get prizes and win option from AJAX
        this.prizes = prizes
        this.step = 360 / this.prizes.length

        this.createVisual(this.context)
    }

    createVisual(ctx) {
        //border:
        ctx.beginPath()

        ctx.arc(this.buffer.width / 2, this.buffer.height / 2,
            this.buffer.width / 2 - 11 - 20, 0, 2 * Math.PI)


        ctx.shadowBlur = 20
        ctx.shadowColor = "black"

        ctx.strokeStyle = '#eaeaea'
        ctx.lineWidth = 9
        ctx.stroke()

        ctx.shadowBlur = 0

        //prize:
        ctx.textAlign = 'right'
        ctx.font = 'bold 14px Arial'

        for (const prize of this.prizes) {
            ctx.beginPath()
            ctx.moveTo(this.buffer.width / 2, this.buffer.height / 2)
            ctx.arc(this.buffer.width / 2, this.buffer.height / 2,
                this.buffer.width / 2 - 16 - 20,
                this.step / 2 * Math.PI / 180,
                -this.step / 2 * Math.PI / 180, true)

            ctx.fillStyle = prize.background
            //ctx.fillStyle = '#9ca3d6'

            ctx.fill()

            ctx.fillStyle = prize.foreground
            //ctx.fillStyle = '#26115e'

            const lines = prize.title.split('\n')

            for (const line in lines)
                ctx.fillText(lines[line], this.buffer.width - 30 - 20, this.buffer.height / 2 + 15 * line + 2)

            ctx.translate(this.buffer.width / 2, this.buffer.height / 2)
            ctx.rotate(this.step * Math.PI / 180)
            ctx.translate(-this.buffer.width / 2, -this.buffer.height / 2)
        }

        //center:
        ctx.beginPath()
        ctx.arc(this.buffer.width / 2, this.buffer.height / 2,
            7, 0, 2 * Math.PI, true)
        ctx.fillStyle = '#888'
        ctx.fill()
    }

    // Rotate the whole wheel to this angle
    rotateAngle(angle) {
        this.originalctx.translate(this.buffer.width / 2, this.buffer.height / 2)
        this.originalctx.rotate(angle * Math.PI / 180)
        this.originalctx.translate(-this.buffer.width / 2, -this.buffer.height / 2)
    }

    // Start spinning the wheel!
    spin(win, callback) {
        this.toAngle = - ( win * this.step) + 5 * 360
        this.speed = 10
    }

    draw(ctx, w, h) {
        ctx.clearRect(0, 0, w, h)

        if (this.toAngle - this.angle > 360) {
            // we still have more than 1 full spin before stoping
            this.angle += this.speed
        } else if (this.angle < this.toAngle && this.speed > 0.04) {
            // we need to start slowing down
            this.angle += this.speed
            this.speed = (this.toAngle - this.angle) / 30
        } else {
            // If the speed goes under 0.4, just stop
            this.speed = 0
        }

        // Draw the wheel at its current angle
        this.rotateAngle(this.angle)
        ctx.drawImage(this.buffer, 0, 0)
        // And rotate canvas back
        this.rotateAngle(-this.angle)

        // Hack this to work with themes ( move to createVicual()? )
        // TODO: Move to createVisual()
        ctx.fillStyle = '#222'
        ctx.beginPath()
        ctx.moveTo(this.buffer.width - 25, this.buffer.height / 2)
        ctx.lineTo(this.buffer.width, this.buffer.height / 2 - 14)
        ctx.lineTo(this.buffer.width, this.buffer.height / 2 + 14)
        ctx.fill()
    }
}

function setCookie(name, value, days) {
    let expires = ""
    const cookieName = value || ""

    if (days) {
        var expireDate = new Date();
        expireDate.setTime(expireDate.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + expireDate.toUTCString();
    }

    // Old way - for backup, if cookies don't work
    // document.cookie = name + "=" + (value || "") + expires + "; path=/";
    document.cookie = `${name}=${cookieName}${expires}"; path=/"`
}

function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');

    for (let c of ca) {
        while (c.charAt(0) == ' ')
            c = c.substring( 1, c.length );
        if ( c.indexOf(nameEQ) == 0 )
            return c.substring(nameEQ.length, c.length);
    }

    return null;
}

function createWheelCanvas (wheel_number) {
    let node = document.createElement("canvas");
    node.width = 400
    node.height = 400
    node.id = 'happy-wheel-' + wheel_number
    node.textContent = 'Sorry, no canvas :('

    return node
}

function createInputForm () {
    let div = document.createElement('div');
    div.id = 'form-mail'

    return div
}

function createSpinButton () {
    let node = document.createElement("button");
    node.textContent = 'Spin'
    node.id = 'wheel-spin'

    return node
}

function createCloseButton () {
    const node = document.createElement('div')
    node.class = 'close-wrapper'
    node.id = 'wheel-close'

    const html = `
    <a href="#" class="close-button">
        <div class="in">
            <div class="close-button-block"></div>
            <div class="close-button-block"></div>
        </div>
        <div class="out">
            <div class="close-button-block"></div>
            <div class="close-button-block"></div>
        </div>
    </a>`

    node.insertAdjacentHTML('afterbegin', html)

    return node
}

function createInput () {
    let node = document.createElement("input");
    node.type = 'email';
    node.placeholder = 'zadaj svoj email';
    node.id = 'wheel-mail'

    return node
}

function validateEmail(email) {
    var re = /\S+@\S+\.\S+/;
    return re.test(email)
}

// Create panel html
let created_wheel;
let wheelContainer = document.getElementById('happy-wheel');
let wheel_number = wheelContainer.getAttribute('wheel-number')

// Insert close button and wheel canvas into panel
wheelContainer.append( createCloseButton() )
wheelContainer.append( createWheelCanvas(wheel_number) )

// Create and append form
const inputForm = createInputForm()
wheelContainer.append( inputForm )
inputForm.append( createInput() )

const canvas = document.getElementById('happy-wheel-' + wheel_number)
const ctx = canvas.getContext('2d')


async function spinWheel(wheel, opt, number, win) {
    const msgs = [];

    // TODO: treba vyriešit aby sa toto spustilo po dotočeni kolesa - otestovat treba toto tuna
    const mail = document.getElementById('wheel-mail').value
    const hexMail = (document.getElementById('wheel-mail').value).hexEncode()

    // Start by validating the email address
    if (mail === "") {
        alert("Zabudol si zadať svoj email")
        return
    } else if ( validateEmail(mail) == false ) {
        alert("Email, ktorý si zadal, je v nesprávnom tvare!")
        return
    }

    const emailUrl = `api/wheel/${wheel_number}/win/${hexMail}/${win}?mail=`+mail

    // First check cookies
    if (getCookie('spinned-wheel-' + number)) {
        alert('Už si hral')
        return;
    }

    // Then check DB
    await _luckyWheel.ajaxRequest(emailUrl, response => {
        // console.log('debug r')
        // console.log(response)
        if (response.status === false) {
            alert('Už si hral')
            return
        } else {
            msgs.push('Gratulujem, výhru ti pošleme na tvoj mail')
        }
    })

    // Spin the wheel!
    await wheel.spin(opt)

    // If everything checks out, save cookie about playing
    setCookie(`spinned-wheel-${number}`, true, 365)

    // Wait until spin stops, then display msgs and hide panel
    setTimeout(() => {
        for (const msg of msgs) {
            alert(msg)
        }

        _luckyWheel.hidePanel()
    }, 5500)
}

// Init koleso
const initWheel = async (callback) => {
    // Get list of prizes
    await _luckyWheel.ajaxRequest('api/wheel/' + wheel_number + '/create', wheelData => {
        created_wheel = new Wheel(canvas, ctx, wheelData.options);

		// Get rid of these lines before production
		console.log(`Vyhral si moznost: ${wheelData.options[wheelData.number].title}, ktora ma id: ${wheelData.number}`)
		console.warn(wheelData)

        // Create "SPIN" button html
        let button = createSpinButton()

        button.setAttribute(
            'onclick',
            `spinWheel(created_wheel, ${wheelData.number}, wheel_number, ${wheelData.win});
                   $('#form-mail').removeClass('phoneKeyboard')`)

        // Append Style to site
        $('head').append(_luckyWheel.css)

        // Append button HTML to site
        inputForm.append(button)

        // Start the loop
        callback()
    })
};

// Init koleso
window.onload =  () => {
    initWheel(function () {
        loop()

        // Show the wheel
        setTimeout( () => {
            $('#happy-wheel').addClass('show')
            $('#overlay').addClass('show')
        }, 1000)
    })
}

// Loop
function loop() {
    _luckyWheel.spinId = undefined

    created_wheel.draw(ctx, created_wheel.buffer.width, created_wheel.buffer.height)

    if (!_luckyWheel.spinId)
        _luckyWheel.spinId = requestAnimationFrame(loop)
}

// Hide the wheel, if user clicks on overlay
$('#overlay').on('click', e => {
    _luckyWheel.hidePanel()
})

// Hide the wheel, if user clicks on "close" button
$('#wheel-close').on('click', e => {
    _luckyWheel.hidePanel()
})

// Move input above keyboard on phones
$('#wheel-mail').on('focus', e => {
    $('#form-mail').addClass('phoneKeyboard')
})
