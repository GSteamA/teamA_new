export class MarkerManager {
    constructor(MarkerClass, map, isDebug = false) {
        this.MarkerClass = MarkerClass;
        this.map = map;
        this.isDebug = isDebug;
        this.markers = [];
    }

    logDebug(methodName, params = null, result = null) {
        if (this.isDebug) {
            console.log(`[MarkerManager] ${methodName}`);
            if (params) console.log('Parameters:', params);
            if (result) console.log('Result:', result);
        }
    }

    async addSampleMarkers() {
        const locations = [
            { lat: 35.669515, lng: 139.702954, title: 'ジーズアカデミー東京' },
            { lat: 33.586843, lng: 130.394501, title: 'ジーズアカデミー福岡' },
            { lat: 36.147685, lng: -115.15651, title: 'ラスベガス' }     
            ];

        this.logDebug('addSampleMarkers', locations);

        locations.forEach(location => {
            const markerContent = this.createMarkerContent(location.title);
            const marker = new this.MarkerClass({
                map: this.map,
                position: location,
                content: markerContent
            });

            marker.addListener('click', () => {
                this.handleMarkerClick(location);
            });

            this.markers.push(marker);
        });
    }

    async addMarkers(locations) {
        // const locations = [
        //     { lat: 35.6812, lng: 139.7671, title: '東京駅' },
        //     { lat: 35.6586, lng: 139.7454, title: '六本木ヒルズ' }
        // ];

        this.logDebug('addSampleMarkers', locations);

        locations.forEach(location => {
            const markerContent = this.createMarkerContent(location.title);
            const marker = new this.MarkerClass({
                map: this.map,
                position: location,
                content: markerContent
            });

            marker.addListener('click', () => {
                this.handleMarkerClick(location);
            });

            this.markers.push(marker);
        });
    }

    createMarkerContent(title) {
        const content = document.createElement('div');
        content.classList.add('marker-content');
        content.textContent = title;
        return content;
    }

    handleMarkerClick(location) {
        this.logDebug('handleMarkerClick', location);
        this.map.panTo(location);
    }
    }