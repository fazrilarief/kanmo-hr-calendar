function initializeToggleButton() {
    const styles = `
        #toggle-btn {
            position: relative;
            background-color: #E0E0E0;
            color: #ff8c00;
            border: none;
            border: none;
            font-size: 13px;
            outline: none;
            cursor: pointer;
            font-weight: bold;
            display: flex;
            align-items: center;
            position: fixed;
            bottom: 20px;
            right: 20px;
            border-top-left-radius: 50px;
            border-top-right-radius: 50px;
            border-bottom-left-radius: 50px;
            box-shadow: 0px 10px 15px rgba(0, 0, 0, 0.1);
        }

        #toggle-btn span {
            position: absolute;
            top: -30px;
            left: 50%;
            transform: translateX(-50%);
            overflow: hidden;
            white-space: nowrap;
        }

        #toggle-btn svg {
            width: 55px;
            height: 55px;
        }

        #iframe-container {
            display: none;
            position: fixed;
            bottom: 60px;
            right: 20px;
            z-index: 999;
        }

        #iframe-container.active {
            display: block;
            margin-bottom: 10px;
        }

        #my-iframe {
            width: 360px;
            height: 500px;
            border: none;
        }
    `;

  const styleElement = document.createElement('style');
    styleElement.textContent = styles;
    document.head.appendChild(styleElement);

    const toggleBtn = document.createElement('button');
    toggleBtn.id = 'toggle-btn';

    const buttonText = document.createElement('span');
    toggleBtn.appendChild(buttonText);

    const textToType = "Hi, I'm Kevas";
    let charIndex = 0;

    function typeText() {
        buttonText.textContent = textToType.substring(0, charIndex);
        charIndex++;

        if (charIndex <= textToType.length) {
            setTimeout(typeText, 150);
        }
    }

    typeText();
    const openIcon = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
    openIcon.id = 'open-icon';
    openIcon.setAttribute('xmlns', 'http://www.w3.org/2000/svg');
    openIcon.setAttribute('viewBox', '0 0 225 225');
    openIcon.innerHTML = '<g transform="translate(0.000000,225.000000) scale(0.100000,-0.100000)" fill="#ff8c00" stroke="none"><path d="M1115 2079 c-378 -55 -656 -252 -774 -550 -31 -78 -61 -231 -61 -313 l0 -70 50 73 c231 335 525 633 800 810 101 65 100 67 -15 50z"/><path d="M1435 2018 c-10 -29 -36 -205 -50 -335 -25 -236 -15 -627 21 -796 l6 -28 56 49 c98 85 209 148 377 216 48 20 103 38 122 42 18 3 33 12 33 20 0 41 -43 221 -70 296 -35 98 -113 228 -187 314 -88 103 -297 254 -308 222z"/><path d="M1201 1820 c-176 -313 -473 -640 -672 -741 -33 -16 -59 -32 -59 -34 0 -3 44 -34 98 -69 163 -105 433 -314 568 -439 57 -53 74 -64 84 -54 12 10 12 9 2 -4 -10 -13 -4 -23 33 -58 25 -23 45 -41 45 -39 0 10 -38 77 -42 73 -2 -2 -4 4 -5 13 0 9 -17 62 -37 117 -134 369 -140 811 -17 1180 17 49 29 90 27 92 -1 2 -13 -15 -25 -37z"/><path d="M1959 912 c-19 -20 -62 -55 -96 -77 -34 -22 -59 -44 -56 -49 4 -5 1 -6 -4 -3 -6 4 -37 -5 -69 -19 -70 -31 -201 -74 -229 -74 -11 0 -26 -4 -33 -9 -29 -18 58 -281 115 -351 l21 -25 59 46 c117 91 231 255 284 407 20 56 50 184 45 189 -2 2 -18 -14 -37 -35z"/><path d="M320 859 c0 -26 64 -198 96 -260 41 -78 122 -179 185 -231 142 -115 396 -194 604 -186 l80 3 -72 28 c-40 16 -77 26 -83 22 -6 -4 -9 -2 -8 4 2 5 -47 34 -108 64 -279 138 -518 325 -643 505 -45 64 -51 70 -51 51z"/></g>';

    const iframeContainer = document.createElement('div');
    iframeContainer.id = 'iframe-container';

    const myIframe = document.createElement('iframe');
    myIframe.id = 'my-iframe';
    myIframe.src = 'https://kanmohris.com/kanmo-hr-bot/';
    myIframe.frameBorder = '0';

    document.body.appendChild(toggleBtn);
    document.body.appendChild(iframeContainer);
    iframeContainer.appendChild(myIframe);
    toggleBtn.appendChild(openIcon);

    toggleBtn.addEventListener('click', function() {
        iframeContainer.classList.toggle('active');

        if (iframeContainer.classList.contains('active')) {
            openIcon.setAttribute('xmlns', 'http://www.w3.org/2000/svg');
            openIcon.setAttribute('viewBox', '0 0 24 24');
            openIcon.innerHTML = '<path d="M18.35 16.65l-4.95-4.95 4.95-4.95-1.41-1.41-4.95 4.95-4.95-4.95-1.41 1.41 4.95 4.95-4.95 4.95 1.41 1.41 4.95-4.95 4.95 4.95 1.41-1.41z" fill="#ff8c00"/>';
             buttonText.style.display = 'none';
        } else {
            openIcon.setAttribute('xmlns', 'http://www.w3.org/2000/svg');
            openIcon.setAttribute('viewBox', '0 0 225 225');
            openIcon.innerHTML = '<g transform="translate(0.000000,225.000000) scale(0.100000,-0.100000)" fill="#ff8c00" stroke="none"><path d="M1115 2079 c-378 -55 -656 -252 -774 -550 -31 -78 -61 -231 -61 -313 l0 -70 50 73 c231 335 525 633 800 810 101 65 100 67 -15 50z"/><path d="M1435 2018 c-10 -29 -36 -205 -50 -335 -25 -236 -15 -627 21 -796 l6 -28 56 49 c98 85 209 148 377 216 48 20 103 38 122 42 18 3 33 12 33 20 0 41 -43 221 -70 296 -35 98 -113 228 -187 314 -88 103 -297 254 -308 222z"/><path d="M1201 1820 c-176 -313 -473 -640 -672 -741 -33 -16 -59 -32 -59 -34 0 -3 44 -34 98 -69 163 -105 433 -314 568 -439 57 -53 74 -64 84 -54 12 10 12 9 2 -4 -10 -13 -4 -23 33 -58 25 -23 45 -41 45 -39 0 10 -38 77 -42 73 -2 -2 -4 4 -5 13 0 9 -17 62 -37 117 -134 369 -140 811 -17 1180 17 49 29 90 27 92 -1 2 -13 -15 -25 -37z"/><path d="M1959 912 c-19 -20 -62 -55 -96 -77 -34 -22 -59 -44 -56 -49 4 -5 1 -6 -4 -3 -6 4 -37 -5 -69 -19 -70 -31 -201 -74 -229 -74 -11 0 -26 -4 -33 -9 -29 -18 58 -281 115 -351 l21 -25 59 46 c117 91 231 255 284 407 20 56 50 184 45 189 -2 2 -18 -14 -37 -35z"/><path d="M320 859 c0 -26 64 -198 96 -260 41 -78 122 -179 185 -231 142 -115 396 -194 604 -186 l80 3 -72 28 c-40 16 -77 26 -83 22 -6 -4 -9 -2 -8 4 2 5 -47 34 -108 64 -279 138 -518 325 -643 505 -45 64 -51 70 -51 51z"/></g>';
            charIndex = 0;
            typeText();
            buttonText.style.display = 'block';
        }
    });
}

initializeToggleButton();

