

export class GoogleMapManager {
constructor(MapClass, MarkerClass, mapElement, config) {
    this.MapClass = MapClass;
    this.MarkerClass = MarkerClass;
    this.mapElement = mapElement;
    this.isDebug = config.isDebug || false;
    this.GOOGLE_MAP_ID = config.GOOGLE_MAP_ID;
    this.mapCenter = config.mapCenter;
    this.mapZoom = config.mapZoom;
    this.map = null;
}

logDebug(methodName, params = null, result = null) {
    if (this.isDebug) {
        console.log(`[GoogleMapManager] ${methodName}`);
        if (params) console.log('Parameters:', params);
        if (result) console.log('Result:', result);
    }
}

async initialize() {
    const mapOptions = {
        center: this.mapCenter,
        zoom: this.mapZoom,
        mapId: this.GOOGLE_MAP_ID
    };
    
    this.logDebug('initialize', mapOptions);
    this.map = new this.MapClass(this.mapElement, mapOptions);
    return this.map;
}
}
