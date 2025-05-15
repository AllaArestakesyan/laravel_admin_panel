<template>
  <div class="profile">
    <div class="card" style="margin: 1rem;">
      <img :src="currentUser.avatar ? '/storage/' + currentUser.avatar : '/storage/uploads/user.png'" alt="User avatar"
        class="avatar" />
      <h2>{{ currentUser.name }} {{ currentUser.surname }}</h2>

      <div>
        <input type="file" @change="onFileChange" accept="image/*" />
        <button @click="uploadAvatar" :disabled="!selectedFile">{{ $t("profile.uploadAvatar") }}</button>
      </div>

      <div class="info">
        <p><strong>{{ $t("profile.email") }}:</strong> {{ currentUser.email }}</p>
      </div>
    </div>
    <div class="search">

      <div>
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#747272">
          <path
            d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252 252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z" />
        </svg>
        <input ref="autocompleteInput" :placeholder='$t("profile.search")' type="text">
      </div>
      <div>

        <div v-if="weatherData.temp">
          <div class="weather">
            <div class="weather-card">
              <img :src="weatherData.icon" alt="">
              <div>
                <div>
                  <p>{{ weatherData.temp }}<sup>o</sup> </p>
                </div>
                <div>
                  <div>
                    <p>{{ weatherData.name }}, {{ weatherData.country }}</p>
                    <p>{{ weatherData.localtime }}</p>
                  </div>
                  <div>
                    {{ weatherData.text }}
                  </div>
                </div>
              </div>
            </div>

            <div class="scroll" ref="scrollRef1">
              <div>
                <span>Hourly Forecast</span>
              </div>
              <div ref="scrollRef" class="scroll-container" @mousedown="onMouseDown" @mouseleave="onMouseLeave"
                @mouseup="onMouseUp" @mousemove="onMouseMove">
                <div v-for="h in hour" :key="h.name">
                  <div>
                    <span>{{ new Date(h.time).getHours() < 10 ? "0" + new Date(h.time).getHours() : new
                      Date(h.time).getHours() }} </span>
                        <span> AM</span>
                  </div>
                  <div>
                    <img :src="h.icon" alt="">
                  </div>
                  <div>
                    <p>{{ h.temp_c }} <sup>o</sup></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
    <div class="slider">
      <div class="slide" v-for="(item, index) in jobs" :key="item.id" :class="{ active: index === currentIndex }">
        <h2>{{ item.title }}</h2>
        <p>{{ item.description }}</p>
        <p><strong>Budget:</strong> ${{ item.budget }}</p>
        <p><em>Last updated:</em> {{ formatDate(item.updated_at) }}</p>
      </div>

      <div class="controls">
        <button @click="prev">‹</button>
        <button @click="next">›</button>
      </div>
    </div>

  </div>
</template>

<script>
import '../../../css/card.scss'
import '../../../css/search.scss'
import '../../../css/slider.scss'
import { ref, reactive } from "vue";

export default {
  name: 'ProfileCard',
  data() {
    return {
      selectedFile: null,
      jobs: [],
      currentIndex: 1,
      weatherData: {},
      hour: [],
    }
  },
  async created() {
    try {
      await this.$store.dispatch("getJobs");
      this.jobs = this.$store.getters['jobs']
    } catch (error) {
      console.error("Failed to load jobs", error);
    }
  },
  computed: {
    currentUser() {
      return this.$store.getters.currentUser
    }
  },
  mounted() {
    if (window.google) {
      this.initAutocomplete();
    } else {
      const checkGoogle = setInterval(() => {
        if (window.google) {
          clearInterval(checkGoogle);
          this.initAutocomplete();
        }
      }, 100);
    }
  },
  setup() {
    const scrollRef = ref(null);
    const state = reactive({
      isDragging: false,
      startX: 0,
      scrollLeft: 0,
    });
   
    const onMouseDown = (e) => {
      state.isDragging = true;
      state.startX = e.pageX - scrollRef.value.offsetLeft;
      state.scrollLeft = scrollRef.value.scrollLeft;
    };

    const onMouseLeave = () => {
      state.isDragging = false;
    };

    const onMouseUp = () => {
      state.isDragging = false;
    };

    const onMouseMove = (e) => {
      if (!state.isDragging) return;
      e.preventDefault();
      const x = e.pageX - scrollRef.value.offsetLeft;
      const walk = (x - state.startX) * 2; // Adjust scroll speed by multiplying
      scrollRef.value.scrollLeft = state.scrollLeft - walk;
    };

    return {
      scrollRef,
      onMouseDown,
      onMouseLeave,
      onMouseUp,
      onMouseMove,
    };
  },
  methods: {
    onFileChange(event) {
      const file = event.target.files && event.target.files[0]
      if (file) {
        this.selectedFile = file
      }
    },
    async uploadAvatar() {
      if (!this.selectedFile) return

      const formData = new FormData()
      formData.append('avatar', this.selectedFile)

      await this.$store.dispatch('updateCurrentUserAvatar', formData)
    },
    next() {
      this.currentIndex = (this.currentIndex + 1) % this.jobs.length;
    },
    prev() {
      this.currentIndex =
        (this.currentIndex - 1 + this.jobs.length) % this.jobs.length;
    },
    formatDate(date) {
      return new Date(date).toLocaleDateString();
    },
    initAutocomplete() {
      const options = {
        types: ["(cities)"],
        // componentRestrictions: { country: "am" },
      };

      const input = this.$refs.autocompleteInput;
      const autocomplete = new google.maps.places.Autocomplete(input, options);

      autocomplete.addListener("place_changed",async () => {
        const place = autocomplete.getPlace();
        console.log(place);
        if (place.name) {

           await this.$store.dispatch('createCountry', {
            name:place.name,
            url:place.url,
            formatted_address:place.formatted_address,
          })

          const apiKey = 'd2e7790ef6a84f91a5455407241311';
          const url = `https://api.weatherapi.com/v1/forecast.json?key=${apiKey}&q=${place.name}`;

          fetch(url)
            .then(response => response.json())
            .then(data => {
              console.log('=>', data);
              console.log('===>', data.forecast.forecastday[0].hour);

              this.weatherData = {
                name: data.location.name,
                country: data.location.country,
                localtime: data.location.localtime,
                temp: data.current.temp_c,
                icon: 'https:' + data.current.condition.icon,
                text: data.current.condition.text
              };
              this.hour = data.forecast.forecastday[0].hour.map(elm => ({
                time: elm.time,
                temp_c: elm.temp_c,
                icon: 'https:' + elm.condition?.icon,
                text: elm.condition?.text

              }));

            })
            .catch(error => {
              console.error('Error fetching weather data:', error);
            });
        } else {
          alert("...")
        }
      });
    },
  }
}
</script>
<style scoped lang="scss">
.profile {
  display: grid;
  grid-template-columns: 1fr 2fr;
  gap: 20px;

  @media (max-width:700px) {
    grid-template-columns: 1fr;
  }
}
</style>