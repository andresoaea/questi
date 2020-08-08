<template>
  <div>
    <!-- <div class="{{ $widget_class }}">
      @if(!empty($widget['title']))
      <h5 class="widget-title">{{ $widget['title'] }}</h5>
      <hr />@endif
      <div class="widget-content">@include('widgets.' . $widget_component)</div>
    </div>-->

    <div v-for="(widget, key, index) in widgets" :class="getWidgetClass(widget, key)">
      <div v-if="widget.title">
        <h5 class="widget-title">{{ widget.title }}</h5>
        <hr />
      </div>
      <div class="wigdet-content">
        <div v-if="widget.data.html" v-html="widget.data.html"></div>
        <div v-else>
          <component :is="key.replace(/_/g, '-')" :widgetData="widget.data" />
        </div>
      </div>
      <!-- <div>{{ getWidgetClass(widget, key) }}</div> -->
    </div>
  </div>
</template>

<script>
import SiteStats from "./SiteStats.vue";
import MostLikedQuestions from "./MostLikedQuestions.vue";

export default {
  data() {
    return {
      widgets: null
    };
  },
  components: {
    "site-stats": SiteStats,
    "most-liked-questions": MostLikedQuestions
  },
  created() {
    this.widgets = JSON.parse(widgets);
    console.log(this.widgets);
  },
  methods: {
    getWidgetClass(widget, key) {
      console.log(widget);

      const fisrtClass = widget.not_standard_layout
        ? "widget-not-standard"
        : "sidebar-widget";
      const secondClass = key.replace(/_/g, "-");

      return `${fisrtClass} widget-${secondClass}`;
    }
    // getWidgetComponent(widgetKey) {
    //   String.prototype.capitalize = function() {
    //     return this.charAt(0).toUpperCase() + this.slice(1);
    //   };
    //   const widgetComponent = widgetKey
    //     .split("_")
    //     .map(word => word.capitalize())
    //     .join("");

    //   return widgetComponent;
    // }
  }
};
</script>