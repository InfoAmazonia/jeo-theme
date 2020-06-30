<template>
  <div class="credited-image-block">
    <div class="image-wrapper">
      <img :src="mediaurl" />
      <div class="image-info-wrapper">
        <span class="image-meta" v-if="displayDescription">
            {{ mediadescription }}
            <span class="fas fa-times" @click="toggleDescription()"></span>
        </span>
        
        <span class="fas fa-camera" @click="toggleDescription()"></span>
      </div>
    </div>
    <div class="image-description">
        {{title}}
    </div>
  </div>
</template>

<script>
export default {
  components: {},
  name: "ImageBlock",
  data() {
        return {
            displayDescription: false,
        };
    },

  props: ["title", "mediaurl", "mediadescription"],
  methods: {
      toggleDescription() {
          this.displayDescription = !this.displayDescription;
      }
  },
  created() {},
};
</script>