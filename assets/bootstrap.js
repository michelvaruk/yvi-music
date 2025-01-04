import { startStimulusApp } from '@symfony/stimulus-bundle';
import Carousel from '@stimulus-components/carousel';
import Lightbox from '@stimulus-components/lightbox';

const app = startStimulusApp();

// register any custom, 3rd party controllers here
app.register('carousel', Carousel);
app.register('lightbox', Lightbox)
