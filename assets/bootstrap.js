import { startStimulusApp } from '@symfony/stimulus-bundle';
import Carousel from '@stimulus-components/carousel'

const app = startStimulusApp();

// register any custom, 3rd party controllers here
app.register('carousel', Carousel);
// app.register('some_controller_name', SomeImportedController);
