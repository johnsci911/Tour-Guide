<template>
    <div class="text-white mb-8 p-4">
        <div class="flex font-sans">
            <div class="venues w-256 h-128 overflow-auto ml-32 mr-2 mt-4 bg-gray-900 rounded-lg">
                <div
                    class="
                        flex
                        sticky
                        top-0
                        bg-gray-900
                        shadow-lg
                        px-4
                        py-4
                        text-left text-sm
                        font-bold
                    "
                >
                    <div>
                        <button
                            class="
                                flex
                                justify-between
                                w-64
                                px-4
                                py-2
                                bg-gray-800
                                text-white
                                font-bold
                                rounded-lg
                                mr-4
                                shadow-lg
                                text-md
                            "
                            @click="toggleDropdown"
                            v-click-outside="hidePlacesMenu"
                        >
                            <div>
                                {{
                                    selectedPlace != ''
                                        ? 'Place: ' + selectedPlace
                                        : 'Please select a place'
                                }}
                            </div>
                            <div>
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M19 9l-7 7-7-7"
                                    />
                                </svg>
                            </div>
                        </button>
                        <div class="absolute mt-2 rounded-lg overflow-hidden" v-if="showMenu">
                            <div
                                class="
                                    w-64
                                    px-4
                                    py-2
                                    bg-gray-700
                                    text-white
                                    cursor-pointer
                                    hover:bg-gray-600
                                "
                                v-for="(place, index) in places"
                                :key="index"
                                @click="placeSelected(place)"
                            >
                                {{ place }}
                            </div>
                        </div>
                    </div>
                    <div class="w-full relative">
                        <div class="absolute top-0 flex items-center h-full ml-2">
                            <svg
                                class="w-4 text-gray-200"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                ></path>
                            </svg>
                        </div>
                        <input
                            v-model="venueQuery"
                            type="search"
                            :placeholder="
                                selectedPlace == '' ? 'Select a place first' : 'Search a venue'
                            "
                            class="
                                w-full
                                rounded-lg
                                bg-gray-800
                                border-none
                                px-4
                                py-2
                                pl-8
                                placeholder-gray-600
                                font-bold
                                focus:outline-none
                            "
                            :disabled="selectedPlace == '' ? true : false"
                            :class="selectedPlace == '' ? 'text-gray-600' : 'text-white'"
                        />
                    </div>
                </div>
                <div class="venue-items text-sm bg-gray-800">
                    <div
                        v-for="(venue, index) in venues"
                        :key="index"
                        class="flex items-center px-4 py-4 hover:bg-gray-900"
                        @click="setLocation(venue.location.lat, venue.location.lng, venue.name, index)"
                        :class="checkVenueSelected(index) ? 'bg-black' : ''"
                    >
                        <div class="flex text-lg text-gray-200">
                            <div class="w-16">
                                <img
                                    v-if="venue.categories.length > 0"
                                    :src="`${venue.categories[0].icon.prefix}32${venue.categories[0].icon.suffix}`"
                                    alt="icon"
                                />
                            </div>
                            <div class="w-60 capitalize">{{ venue.name }}</div>
                        </div>
                        <div class="px-4 flex items-center">
                            <div class="w-64 ml-3 capitalize align-top">
                                {{ venue.location.formattedAddress[0] }}
                            </div>
                            <div class="w-40 ml-3 capitalize align-top">
                                {{ venue.location.formattedAddress[1] }}
                            </div>
                            <div class="w-20 ml-3 capitalize align-top">
                                {{ venue.location.formattedAddress[2] }}
                            </div>
                            <div class="ml-3 capitalize align-top">
                                {{ venue.location.formattedAddress[3] }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end venues -->
            <div
                class="
                    weather-container
                    w-128
                    h-128
                    overflow-auto
                    bg-gray-900
                    shadow-lg
                    mt-4
                    rounded-lg
                "
            >
                <div class="current-weather px-6 py-8 sticky top-0 bg-gray-900">
                    <div v-if="selectedPlace != ''" class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div>
                                <div class="text-6xl font-semibold mb-2">
                                    {{ currentTemp.actual }}ºc
                                </div>
                                <div>Feels like {{ currentTemp.feelsLike }}ºc</div>
                            </div>
                            <div class="mx-5">
                                <div class="capitalize font-semibold">
                                    {{ currentTemp.summary }}
                                </div>
                                <div class="w-52">
                                    {{
                                        location.venueName != ''
                                            ? location.venueName
                                            : location.name
                                    }}
                                </div>
                            </div>
                        </div>
                        <div>
                            <img :src="currentTemp.icon" alt="icon" />
                        </div>
                    </div>
                    <div v-else class="text-lg w-full font-bold text-center">
                        <p>No weather info</p>
                    </div>
                </div>
                <!-- end current-weather -->
                <div class="future-weather text-sm bg-gray-800 px-6">
                    <div
                        v-for="(day, index) in dailyWeather"
                        :key="day.dt"
                        class="flex items-center py-4"
                        :class="{ 'mt-8': index > 0 }"
                    >
                        <div class="w-1/4 flex text-lg text-gray-200">
                            <div class="w-1/2 capitalize">
                                {{ toDayOfWeek(day.dt) }}
                            </div>
                            <div>{{ toTime(day.dt) }}</div>
                        </div>
                        <div class="w-4/6 px-4 flex items-center">
                            <div class="w-1/5">
                                <img
                                    :src="`http://openweathermap.org/img/wn/${day.weather[0].icon}@2x.png`"
                                    alt="icon"
                                    width="40"
                                    height="40"
                                />
                            </div>
                            <div class="ml-3 capitalize">
                                {{ day.weather[0].description }}
                            </div>
                        </div>
                        <div class="w-1/6 text-right">
                            <div>{{ Math.round(day.main.temp_min) }}ºc</div>
                            <div>{{ Math.round(day.main.temp_max) }}ºc</div>
                        </div>
                    </div>
                </div>
                <!-- end future-weather -->
            </div>
            <!-- end weather-container -->
        </div>
    </div>
</template>

<script>
export default {
    watch: {
        selectedPlace() {
            this.searchVenue();
            this.fetchWeather(this.location.lat, this.location.lon);

            this.venues = [];
        },
        venueQuery() {
            this.searchVenue();
        },
    },
    data() {
        return {
            currentTemp: {
                actual: '',
                feelsLike: '',
                summary: '',
                icon: '',
            },
            location: {
                name: '',
                venueName: '',
                lat: 0,
                lon: 0,
            },
            venueQuery: '',
            dailyWeather: [],
            venues: [],
            venueSelected: 0,
            places: ['Tokyo', 'Yokohama', 'Kyoto', 'Osaka', 'Sapporo', 'Nagoya'],
            showMenu: false,
            selectedPlace: '',
        };
    },
    mounted() {
        // this.fetchWeather();
    },
    methods: {
        fetchWeather(lat, lon) {
            fetch(`/api/weather?lat=${lat}&lon=${lon}`)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    this.currentTemp.actual = Math.round(data.list[0].main.temp);
                    this.currentTemp.feelsLike = Math.round(data.list[0].main.feels_like);
                    this.currentTemp.icon = data.list[0].weather[0].icon;
                    this.currentTemp.summary = data.list[0].weather[0].description;
                    this.location.name = data.city.name;
                    this.currentTemp.icon = `http://openweathermap.org/img/wn/${data.list[0].weather[0].icon}@2x.png`;
                    this.dailyWeather = data.list;
                });
        },
        searchVenue() {
            fetch(`/api/venue?city=${this.selectedPlace}&query=${this.venueQuery}`)
                .then(response => response.json())
                .then(data => {
                    this.location.lat = data.response.geocode.feature.geometry.center.lat;
                    this.location.lon = data.response.geocode.feature.geometry.center.lng;
                    this.location.name = data.response.geocode.feature.name;

                    this.venues = data.response.venues;
                });
        },
        toDayOfWeek(timestamp) {
            var newDate = new Date(timestamp * 1000);
            var days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

            return days[newDate.getDay()];
        },
        toTime(timestamp) {
            var date = new Date(timestamp * 1000);

            var hours = date.getHours();
            var minutes = '0' + date.getMinutes();

            return hours + ':' + minutes.substr(-2);
        },
        toggleDropdown() {
            this.showMenu = !this.showMenu;
        },
        placeSelected(place) {
            this.toggleDropdown();
            this.selectedPlace = place;
        },
        hidePlacesMenu() {
            this.showMenu = false;
        },
        setLocation(lat, lon, name, index) {
            this.location.lat = lat;
            this.location.lon = lon;
            this.location.venueName = name;
            this.venueSelected = index;

            this.fetchWeather(lat, lon);
        },
        checkVenueSelected(index) {
            if (index == this.venueSelected) {
                return true
            } else {
                return false
            }
        }
    },
};
</script>
