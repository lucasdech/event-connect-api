import axios from 'axios';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.axios = axios;

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: true
});

var channel = Echo.channel('event-connect');
channel.listen('chat', function(data) {
  alert(JSON.stringify(data));
});

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
