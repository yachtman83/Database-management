import './bootstrap';
import { createApp } from 'vue';
import ExampleComponent from './components/ExampleComponent.vue'; // Подключение компонента

const app = createApp({});

app.component('example-component', ExampleComponent); // Регистрация компонента

app.mount('#app'); // Монтирование Vue в контейнер с id="app"
