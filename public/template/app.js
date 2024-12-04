const chatButton = document.querySelector('.chatbox__button');
const chatContent = document.querySelector('.chatbox__support');

const icons = {
    isClicked: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#ff8c00" width="36" height="36"><path d="M18.35 16.65l-4.95-4.95 4.95-4.95-1.41-1.41-4.95 4.95-4.95-4.95-1.41 1.41 4.95 4.95-4.95 4.95 1.41 1.41 4.95-4.95 4.95 4.95 1.41-1.41z"/></svg>',
    isNotClicked: '<svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" fill="#ff8c00"></circle><path fill="#fff" d="M17.5,10h-0.53l0.01-0.97c0.008-0.807-0.301-1.567-0.869-2.141S14.787,6,13.98,6H9v-1.277	c0.595-0.346,1-0.984,1-1.723c0-1.105-0.895-2-2-2s-2,0.895-2,2c0,0.738,0.405,1.376,1,1.723V6H3c-1.654,0-3,1.346-3,3v1h-0.5	c-0.552,0-1,0.448-1,1v4c0,0.552,0.448,1,1,1H5v2c0,1.654,1.346,3,3,3h7.89c1.637,0,2.983-1.332,3-2.97L16.91,16h0.59	c0.552,0,1-0.448,1-1v-4C18.5,10.448,18.052,10,17.5,10z M14.89,18.01c-0.005,0.546-0.454,0.99-1,0.99H3c-0.551,0-1-0.449-1-1v-9	c0-0.551,0.449-1,1-1h11.98c0.269,0,0.521,0.105,0.71,0.296s0.292,0.445,0.29,0.714L14.89,18.01z"></path><rect width="2" height="3" x="5" y="13" fill="#fff"></rect><rect width="2" height="3" x="13" y="13" fill="#fff"></rect><rect width="6" height="2" x="7" y="17" fill="#fff"></rect></svg>',
}

const chatbox = new InteractiveChatbox(chatButton, chatContent, icons);
chatbox.display();
chatbox.toggleIcon(false, chatButton);
