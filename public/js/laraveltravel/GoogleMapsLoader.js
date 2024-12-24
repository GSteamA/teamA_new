import {GoogleMapManager} from './GoogleMapManager.js';
import { MarkerManager } from './MarkerManager.js';

export class GoogleMapsLoader {
  constructor(config, elements, isDebug){
    this.GOOGLE_MAPS_API_KEY = config.GOOGLE_MAPS_API_KEY;
    this.elements = elements;
    this.isDebug = isDebug;
    this.config = config;
    this.markerManager = null;
  }

  logDebug(methodName, params = null, result = null) {
    if (this.isDebug) {
        console.log(`[GoogleMapManager] ${methodName}`);
        if (params) console.log('Parameters:', params);
        if (result) console.log('Result:', result);
    }
}

  async loadGoogleMapsAPI() {
    //Jqueryだと非同期の処理がうまくいかない？疑惑のため、vanila Javascriptで記述
      return new Promise((resolve, reject) => {
          const script = document.createElement('script');
          script.src = `https://maps.googleapis.com/maps/api/js?key=${this.GOOGLE_MAPS_API_KEY}&v=beta`;
          script.async = true;
          script.defer = true;
          script.addEventListener('load', () => resolve());
          script.addEventListener('error', () => reject(new Error('Google Maps API の読み込みに失敗しました')));
          document.head.appendChild(script);
      });
  }

  async initializeMap() {
      const { Map } = await google.maps.importLibrary("maps");
      const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");
      
      const mapManager = new GoogleMapManager(Map, AdvancedMarkerElement, this.elements.$map[0], this.config);
      await mapManager.initialize();
      
      this.markerManager = new MarkerManager(AdvancedMarkerElement, mapManager.map, this.isDebug);
      // await this.markerManager.addSampleMarkers();

      // return {Map, AdvancedMarkerElement }

  }

  async addSampleMarker () {
    await this.markerManager.addSampleMarkers();
  }

  async addMarker (locations) {
    await this.markerManager.addMarkers(locations);
  }




}