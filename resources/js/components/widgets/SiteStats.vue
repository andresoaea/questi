<template>
  <div class="row">
    <div v-for="stat in widgetData" class="col-6">
      <div class="circle-tile">
        <div class="circle-tile-heading dark-blue">
          <i :class="`fa fa-${stat.icon}`"></i>
        </div>
        <div class="circle-tile-content dark-blue">
          <div class="circle-tile-description text-faded">{{ stat.text }}</div>
          <div class="circle-tile-number text-faded">{{ stat.number }}</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["widgetData"]
};
</script>