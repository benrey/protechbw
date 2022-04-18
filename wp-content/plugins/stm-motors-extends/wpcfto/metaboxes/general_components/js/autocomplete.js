(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);throw new Error("Cannot find module '"+o+"'")}var f=n[o]={exports:{}};t[o][0].call(f.exports,function(e){var n=t[o][1][e];return s(n?n:e)},f,f.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
"use strict";

Vue.component('v-select', VueSelect.VueSelect);
Vue.component('wpcfto_autocomplete', {
  props: ['fields', 'field_label', 'field_name', 'field_id', 'field_value', 'field_data'],
  data: function data() {
    return {
      ids: [],
      items: [],
      search: '',
      options: [],
      loading: true,
      itemHovered: null,
      value: '',
      limit: 0
    };
  },
  template: "\n        <div class=\"wpcfto_generic_field wpcfto_generic_field_autocomplete\">\n\n            <wpcfto_fields_aside_before :fields=\"fields\" :field_label=\"field_label\"></wpcfto_fields_aside_before>\n\n            <div class=\"wpcfto-field-content\">\n\n                <div class=\"wpcfto-autocomplete-search\" v-bind:class=\"{'loading': loading}\">\n                  \n                    <div class=\"v-select-search\" v-if=\"underLimit()\">\n\n                        <i class=\"fa fa-plus-circle\"></i>\n\n                        <v-select label=\"title\"\n                                  v-model=\"search\"\n                                  @input=\"setSelected($event)\"\n                                  :options=\"options\"\n                                  @search=\"onSearch($event)\">\n                        </v-select>\n\n                    </div>\n\n                    <ul class=\"wpcfto-autocomplete\" v-bind:class=\"{'limited' : !underLimit()}\">\n                        <li v-for=\"(item, index) in items\" v-if=\"typeof item !== 'string'\" :class=\"{ 'hovered' : itemHovered == index }\">\n                            <div class=\"item-wrapper\">\n                                <img v-bind:src=\"item.image\" v-if=\"item.image\" class=\"item-image\">\n                                <div class=\"item-data\">\n                                    <span v-html=\"item.title\" class=\"item-title\"></span>\n                                    <span v-html=\"item.excerpt\" class=\"item-excerpt\" v-if=\"item.excerpt\"></span>\n                                </div>\n                            </div>\n                            <i class=\"fa fa-trash-alt\" @click=\"removeItem(index)\" @mouseover=\"itemHovered = index\" @mouseleave=\"itemHovered = null\"></i>\n                        </li>\n                    </ul>\n\n                    <input type=\"hidden\"\n                           v-bind:name=\"field_name\"\n                           v-model=\"value\"/>\n\n                </div>\n            \n            </div>\n\n            <wpcfto_fields_aside_after :fields=\"fields\"></wpcfto_fields_aside_after>\n\n        </div>\n    ",
  created: function created() {
    if (this.field_value) {
      this.getPosts(stm_wpcfto_ajaxurl + '?action=wpcfto_search_posts&nonce=' + stm_wpcfto_nonces['wpcfto_search_posts'] + '&posts_per_page=-1&orderby=post__in&ids=' + this.field_value + '&post_types=' + this.fields.post_type.join(','), 'items');
    } else {
      this.clearItems();
      this.isLoading(false);
    }

    if (typeof this.field_data.limit !== 'undefined') {
      this.limit = this.field_data.limit;
    }
  },
  methods: {
    isLoading: function isLoading(_isLoading) {
      this.loading = _isLoading;
    },
    setSelected: function setSelected(value) {
      if (value) this.items.push(value);
      /*Reset options*/

      this.$set(this, 'options', []);
      this.$set(this, 'search', '');
    },
    clearItems: function clearItems() {
      var vm = this;
      var filtered = vm['items'].filter(function (el) {
        return el != null || el !== '';
      });
      vm.$set(vm, 'items', filtered);
    },
    underLimit: function underLimit() {
      return this.items.length < this.limit;
    },
    onSearch: function onSearch(search) {
      var _this = this;

      var exclude = _this.ids.join(',');

      var post_types = _this.fields['post_type'].join(',');

      _this.getPosts(stm_wpcfto_ajaxurl + '?action=wpcfto_search_posts&nonce=' + stm_wpcfto_nonces['wpcfto_search_posts'] + '&exclude_ids=' + exclude + '&s=' + search + '&post_types=' + post_types, 'options');
    },
    getPosts: function getPosts(url, variable) {
      var vm = this;
      vm.isLoading(true);
      /*Adding field ID to filters then*/

      url += '&name=' + vm.field_name;
      this.$http.get(url).then(function (response) {
        vm[variable] = response.body;
        vm.clearItems();
        vm.isLoading(false);
      });
    },
    updateIds: function updateIds() {
      var vm = this;
      vm.ids = [];
      this.items.forEach(function (value, key) {
        vm.ids.push(value.id);
      });
      vm.$set(this, 'value', vm.ids);
      vm.$emit('wpcfto-get-value', vm.ids);
    },
    callFunction: function callFunction(functionName, item, model) {
      functionName(item, model);
    },
    containsObject: function containsObject(obj, list) {
      var i;

      for (i = 0; i < list.length; i++) {
        if (list[i]['id'] === obj['id']) {
          return true;
        }
      }

      return false;
    },
    removeItem: function removeItem(index) {
      this.items.splice(index, 1);
    }
  },
  watch: {
    items: function items() {
      this.updateIds();
    }
  }
});
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbImZha2VfNzcwM2NhZTguanMiXSwibmFtZXMiOlsiVnVlIiwiY29tcG9uZW50IiwiVnVlU2VsZWN0IiwicHJvcHMiLCJkYXRhIiwiaWRzIiwiaXRlbXMiLCJzZWFyY2giLCJvcHRpb25zIiwibG9hZGluZyIsIml0ZW1Ib3ZlcmVkIiwidmFsdWUiLCJsaW1pdCIsInRlbXBsYXRlIiwiY3JlYXRlZCIsImZpZWxkX3ZhbHVlIiwiZ2V0UG9zdHMiLCJzdG1fd3BjZnRvX2FqYXh1cmwiLCJzdG1fd3BjZnRvX25vbmNlcyIsImZpZWxkcyIsInBvc3RfdHlwZSIsImpvaW4iLCJjbGVhckl0ZW1zIiwiaXNMb2FkaW5nIiwiZmllbGRfZGF0YSIsIm1ldGhvZHMiLCJfaXNMb2FkaW5nIiwic2V0U2VsZWN0ZWQiLCJwdXNoIiwiJHNldCIsInZtIiwiZmlsdGVyZWQiLCJmaWx0ZXIiLCJlbCIsInVuZGVyTGltaXQiLCJsZW5ndGgiLCJvblNlYXJjaCIsIl90aGlzIiwiZXhjbHVkZSIsInBvc3RfdHlwZXMiLCJ1cmwiLCJ2YXJpYWJsZSIsImZpZWxkX25hbWUiLCIkaHR0cCIsImdldCIsInRoZW4iLCJyZXNwb25zZSIsImJvZHkiLCJ1cGRhdGVJZHMiLCJmb3JFYWNoIiwia2V5IiwiaWQiLCIkZW1pdCIsImNhbGxGdW5jdGlvbiIsImZ1bmN0aW9uTmFtZSIsIml0ZW0iLCJtb2RlbCIsImNvbnRhaW5zT2JqZWN0Iiwib2JqIiwibGlzdCIsImkiLCJyZW1vdmVJdGVtIiwiaW5kZXgiLCJzcGxpY2UiLCJ3YXRjaCJdLCJtYXBwaW5ncyI6IkFBQUE7O0FBRUFBLEdBQUcsQ0FBQ0MsU0FBSixDQUFjLFVBQWQsRUFBMEJDLFNBQVMsQ0FBQ0EsU0FBcEM7QUFDQUYsR0FBRyxDQUFDQyxTQUFKLENBQWMscUJBQWQsRUFBcUM7QUFDbkNFLEVBQUFBLEtBQUssRUFBRSxDQUFDLFFBQUQsRUFBVyxhQUFYLEVBQTBCLFlBQTFCLEVBQXdDLFVBQXhDLEVBQW9ELGFBQXBELEVBQW1FLFlBQW5F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QUFoQztBQUNELEtBbERNO0FBbURQZ0QsSUFBQUEsWUFBWSxFQUFFLFNBQVNBLFlBQVQsQ0FBc0JDLFlBQXRCLEVBQW9DQyxJQUFwQyxFQUEwQ0MsS0FBMUMsRUFBaUQ7QUFDN0RGLE1BQUFBLFlBQVksQ0FBQ0MsSUFBRCxFQUFPQyxLQUFQLENBQVo7QUFDRCxLQXJETTtBQXNEUEMsSUFBQUEsY0FBYyxFQUFFLFNBQVNBLGNBQVQsQ0FBd0JDLEdBQXhCLEVBQTZCQyxJQUE3QixFQUFtQztBQUNqRCxVQUFJQyxDQUFKOztBQUVBLFdBQUtBLENBQUMsR0FBRyxDQUFULEVBQVlBLENBQUMsR0FBR0QsSUFBSSxDQUFDeEIsTUFBckIsRUFBNkJ5QixDQUFDLEVBQTlCLEVBQWtDO0FBQ2hDLFlBQUlELElBQUksQ0FBQ0MsQ0FBRCxDQUFKLENBQVEsSUFBUixNQUFrQkYsR0FBRyxDQUFDLElBQUQsQ0FBekIsRUFBaUM7QUFDL0IsaUJBQU8sSUFBUDtBQUNEO0FBQ0Y7O0FBRUQsYUFBTyxLQUFQO0FBQ0QsS0FoRU07QUFpRVBHLElBQUFBLFVBQVUsRUFBRSxTQUFTQSxVQUFULENBQW9CQyxLQUFwQixFQUEyQjtBQUNyQyxXQUFLeEQsS0FBTCxDQUFXeUQsTUFBWCxDQUFrQkQsS0FBbEIsRUFBeUIsQ0FBekI7QUFDRDtBQW5FTSxHQTNCMEI7QUFnR25DRSxFQUFBQSxLQUFLLEVBQUU7QUFDTDFELElBQUFBLEtBQUssRUFBRSxTQUFTQSxLQUFULEdBQWlCO0FBQ3RCLFdBQUswQyxTQUFMO0FBQ0Q7QUFISTtBQWhHNEIsQ0FBckMiLCJzb3VyY2VzQ29udGVudCI6WyJcInVzZSBzdHJpY3RcIjtcblxuVnVlLmNvbXBvbmVudCgndi1zZWxlY3QnLCBWdWVTZWxlY3QuVnVlU2VsZWN0KTtcblZ1ZS5jb21wb25lbnQoJ3dwY2Z0b19hdXRvY29tcGxldGUnLCB7XG4gIHByb3BzOiBbJ2ZpZWxkcycsICdmaWVsZF9sYWJlbCcsICdmaWVsZF9uYW1lJywgJ2ZpZWxkX2lkJywgJ2ZpZWxkX3ZhbHVlJywgJ2ZpZWxkX2RhdGEnXSxcbiAgZGF0YTogZnVuY3Rpb24gZGF0YSgpIHtcbiAgICByZXR1cm4ge1xuICAgICAgaWRzOiBbXSxcbiAgICAgIGl0ZW1zOiBbXSxcbiAgICAgIHNlYXJjaDogJycsXG4gICAgICBvcHRpb25zOiBbXSxcbiAgICAgIGxvYWRpbmc6IHRydWUsXG4gICAgICBpdGVtSG92ZXJlZDogbnVsbCxcbiAgICAgIHZhbHVlOiAnJyxcbiAgICAgIGxpbWl0OiAwXG4gICAgfTtcbiAgfSxcbiAgdGVtcGxhdGU6IFwiXFxuICAgICAgICA8ZGl2IGNsYXNzPVxcXCJ3cGNmdG9fZ2VuZXJpY19maWVsZCB3cGNmdG9fZ2VuZXJpY19maWVsZF9hdXRvY29tcGxldGVcXFwiPlxcblxcbiAgICAgICAgICAgIDx3cGNmdG9fZmllbGRzX2FzaWRlX2JlZm9yZSA6ZmllbGRzPVxcXCJmaWVsZHNcXFwiIDpmaWVsZF9sYWJlbD1cXFwiZmllbGRfbGFiZWxcXFwiPjwvd3BjZnRvX2ZpZWxkc19hc2lkZV9iZWZvcmU+XFxuXFxuICAgICAgICAgICAgPGRpdiBjbGFzcz1cXFwid3BjZnRvLWZpZWxkLWNvbnRlbnRcXFwiPlxcblxcbiAgICAgICAgICAgICAgICA8ZGl2IGNsYXNzPVxcXCJ3cGNmdG8tYXV0b2NvbXBsZXRlLXNlYXJjaFxcXCIgdi1iaW5kOmNsYXNzPVxcXCJ7J2xvYWRpbmcnOiBsb2FkaW5nfVxcXCI+XFxuICAgICAgICAgICAgICAgICAgXFxuICAgICAgICAgICAgICAgICAgICA8ZGl2IGNsYXNzPVxcXCJ2LXNlbGVjdC1zZWFyY2hcXFwiIHYtaWY9XFxcInVuZGVyTGltaXQoKVxcXCI+XFxuXFxuICAgICAgICAgICAgICAgICAgICAgICAgPGkgY2xhc3M9XFxcImZhIGZhLXBsdXMtY2lyY2xlXFxcIj48L2k+XFxuXFxuICAgICAgICAgICAgICAgICAgICAgICAgPHYtc2VsZWN0IGxhYmVsPVxcXCJ0aXRsZVxcXCJcXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgdi1tb2RlbD1cXFwic2VhcmNoXFxcIlxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBAaW5wdXQ9XFxcInNldFNlbGVjdGVkKCRldmVudClcXFwiXFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDpvcHRpb25zPVxcXCJvcHRpb25zXFxcIlxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICBAc2VhcmNoPVxcXCJvblNlYXJjaCgkZXZlbnQpXFxcIj5cXG4gICAgICAgICAgICAgICAgICAgICAgICA8L3Ytc2VsZWN0PlxcblxcbiAgICAgICAgICAgICAgICAgICAgPC9kaXY+XFxuXFxuICAgICAgICAgICAgICAgICAgICA8dWwgY2xhc3M9XFxcIndwY2Z0by1hdXRvY29tcGxldGVcXFwiIHYtYmluZDpjbGFzcz1cXFwieydsaW1pdGVkJyA6ICF1bmRlckxpbWl0KCl9XFxcIj5cXG4gICAgICAgICAgICAgICAgICAgICAgICA8bGkgdi1mb3I9XFxcIihpdGVtLCBpbmRleCkgaW4gaXRlbXNcXFwiIHYtaWY9XFxcInR5cGVvZiBpdGVtICE9PSAnc3RyaW5nJ1xcXCIgOmNsYXNzPVxcXCJ7ICdob3ZlcmVkJyA6IGl0ZW1Ib3ZlcmVkID09IGluZGV4IH1cXFwiPlxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICA8ZGl2IGNsYXNzPVxcXCJpdGVtLXdyYXBwZXJcXFwiPlxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgPGltZyB2LWJpbmQ6c3JjPVxcXCJpdGVtLmltYWdlXFxcIiB2LWlmPVxcXCJpdGVtLmltYWdlXFxcIiBjbGFzcz1cXFwiaXRlbS1pbWFnZVxcXCI+XFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICA8ZGl2IGNsYXNzPVxcXCJpdGVtLWRhdGFcXFwiPlxcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIDxzcGFuIHYtaHRtbD1cXFwiaXRlbS50aXRsZVxcXCIgY2xhc3M9XFxcIml0ZW0tdGl0bGVcXFwiPjwvc3Bhbj5cXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICA8c3BhbiB2LWh0bWw9XFxcIml0ZW0uZXhjZXJwdFxcXCIgY2xhc3M9XFxcIml0ZW0tZXhjZXJwdFxcXCIgdi1pZj1cXFwiaXRlbS5leGNlcnB0XFxcIj48L3NwYW4+XFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICA8L2Rpdj5cXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgPC9kaXY+XFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgIDxpIGNsYXNzPVxcXCJmYSBmYS10cmFzaC1hbHRcXFwiIEBjbGljaz1cXFwicmVtb3ZlSXRlbShpbmRleClcXFwiIEBtb3VzZW92ZXI9XFxcIml0ZW1Ib3ZlcmVkID0gaW5kZXhcXFwiIEBtb3VzZWxlYXZlPVxcXCJpdGVtSG92ZXJlZCA9IG51bGxcXFwiPjwvaT5cXG4gICAgICAgICAgICAgICAgICAgICAgICA8L2xpPlxcbiAgICAgICAgICAgICAgICAgICAgPC91bD5cXG5cXG4gICAgICAgICAgICAgICAgICAgIDxpbnB1dCB0eXBlPVxcXCJoaWRkZW5cXFwiXFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgdi1iaW5kOm5hbWU9XFxcImZpZWxkX25hbWVcXFwiXFxuICAgICAgICAgICAgICAgICAgICAgICAgICAgdi1tb2RlbD1cXFwidmFsdWVcXFwiLz5cXG5cXG4gICAgICAgICAgICAgICAgPC9kaXY+XFxuICAgICAgICAgICAgXFxuICAgICAgICAgICAgPC9kaXY+XFxuXFxuICAgICAgICAgICAgPHdwY2Z0b19maWVsZHNfYXNpZGVfYWZ0ZXIgOmZpZWxkcz1cXFwiZmllbGRzXFxcIj48L3dwY2Z0b19maWVsZHNfYXNpZGVfYWZ0ZXI+XFxuXFxuICAgICAgICA8L2Rpdj5cXG4gICAgXCIsXG4gIGNyZWF0ZWQ6IGZ1bmN0aW9uIGNyZWF0ZWQoKSB7XG4gICAgaWYgKHRoaXMuZmllbGRfdmFsdWUpIHtcbiAgICAgIHRoaXMuZ2V0UG9zdHMoc3RtX3dwY2Z0b19hamF4dXJsICsgJz9hY3Rpb249d3BjZnRvX3NlYXJjaF9wb3N0cyZub25jZT0nICsgc3RtX3dwY2Z0b19ub25jZXNbJ3dwY2Z0b19zZWFyY2hfcG9zdHMnXSArICcmcG9zdHNfcGVyX3BhZ2U9LTEmb3JkZXJieT1wb3N0X19pbiZpZHM9JyArIHRoaXMuZmllbGRfdmFsdWUgKyAnJnBvc3RfdHlwZXM9JyArIHRoaXMuZmllbGRzLnBvc3RfdHlwZS5qb2luKCcsJyksICdpdGVtcycpO1xuICAgIH0gZWxzZSB7XG4gICAgICB0aGlzLmNsZWFySXRlbXMoKTtcbiAgICAgIHRoaXMuaXNMb2FkaW5nKGZhbHNlKTtcbiAgICB9XG5cbiAgICBpZiAodHlwZW9mIHRoaXMuZmllbGRfZGF0YS5saW1pdCAhPT0gJ3VuZGVmaW5lZCcpIHtcbiAgICAgIHRoaXMubGltaXQgPSB0aGlzLmZpZWxkX2RhdGEubGltaXQ7XG4gICAgfVxuICB9LFxuICBtZXRob2RzOiB7XG4gICAgaXNMb2FkaW5nOiBmdW5jdGlvbiBpc0xvYWRpbmcoX2lzTG9hZGluZykge1xuICAgICAgdGhpcy5sb2FkaW5nID0gX2lzTG9hZGluZztcbiAgICB9LFxuICAgIHNldFNlbGVjdGVkOiBmdW5jdGlvbiBzZXRTZWxlY3RlZCh2YWx1ZSkge1xuICAgICAgaWYgKHZhbHVlKSB0aGlzLml0ZW1zLnB1c2godmFsdWUpO1xuICAgICAgLypSZXNldCBvcHRpb25zKi9cblxuICAgICAgdGhpcy4kc2V0KHRoaXMsICdvcHRpb25zJywgW10pO1xuICAgICAgdGhpcy4kc2V0KHRoaXMsICdzZWFyY2gnLCAnJyk7XG4gICAgfSxcbiAgICBjbGVhckl0ZW1zOiBmdW5jdGlvbiBjbGVhckl0ZW1zKCkge1xuICAgICAgdmFyIHZtID0gdGhpcztcbiAgICAgIHZhciBmaWx0ZXJlZCA9IHZtWydpdGVtcyddLmZpbHRlcihmdW5jdGlvbiAoZWwpIHtcbiAgICAgICAgcmV0dXJuIGVsICE9IG51bGwgfHwgZWwgIT09ICcnO1xuICAgICAgfSk7XG4gICAgICB2bS4kc2V0KHZtLCAnaXRlbXMnLCBmaWx0ZXJlZCk7XG4gICAgfSxcbiAgICB1bmRlckxpbWl0OiBmdW5jdGlvbiB1bmRlckxpbWl0KCkge1xuICAgICAgcmV0dXJuIHRoaXMuaXRlbXMubGVuZ3RoIDwgdGhpcy5saW1pdDtcbiAgICB9LFxuICAgIG9uU2VhcmNoOiBmdW5jdGlvbiBvblNlYXJjaChzZWFyY2gpIHtcbiAgICAgIHZhciBfdGhpcyA9IHRoaXM7XG5cbiAgICAgIHZhciBleGNsdWRlID0gX3RoaXMuaWRzLmpvaW4oJywnKTtcblxuICAgICAgdmFyIHBvc3RfdHlwZXMgPSBfdGhpcy5maWVsZHNbJ3Bvc3RfdHlwZSddLmpvaW4oJywnKTtcblxuICAgICAgX3RoaXMuZ2V0UG9zdHMoc3RtX3dwY2Z0b19hamF4dXJsICsgJz9hY3Rpb249d3BjZnRvX3NlYXJjaF9wb3N0cyZub25jZT0nICsgc3RtX3dwY2Z0b19ub25jZXNbJ3dwY2Z0b19zZWFyY2hfcG9zdHMnXSArICcmZXhjbHVkZV9pZHM9JyArIGV4Y2x1ZGUgKyAnJnM9JyArIHNlYXJjaCArICcmcG9zdF90eXBlcz0nICsgcG9zdF90eXBlcywgJ29wdGlvbnMnKTtcbiAgICB9LFxuICAgIGdldFBvc3RzOiBmdW5jdGlvbiBnZXRQb3N0cyh1cmwsIHZhcmlhYmxlKSB7XG4gICAgICB2YXIgdm0gPSB0aGlzO1xuICAgICAgdm0uaXNMb2FkaW5nKHRydWUpO1xuICAgICAgLypBZGRpbmcgZmllbGQgSUQgdG8gZmlsdGVycyB0aGVuKi9cblxuICAgICAgdXJsICs9ICcmbmFtZT0nICsgdm0uZmllbGRfbmFtZTtcbiAgICAgIHRoaXMuJGh0dHAuZ2V0KHVybCkudGhlbihmdW5jdGlvbiAocmVzcG9uc2UpIHtcbiAgICAgICAgdm1bdmFyaWFibGVdID0gcmVzcG9uc2UuYm9keTtcbiAgICAgICAgdm0uY2xlYXJJdGVtcygpO1xuICAgICAgICB2bS5pc0xvYWRpbmcoZmFsc2UpO1xuICAgICAgfSk7XG4gICAgfSxcbiAgICB1cGRhdGVJZHM6IGZ1bmN0aW9uIHVwZGF0ZUlkcygpIHtcbiAgICAgIHZhciB2bSA9IHRoaXM7XG4gICAgICB2bS5pZHMgPSBbXTtcbiAgICAgIHRoaXMuaXRlbXMuZm9yRWFjaChmdW5jdGlvbiAodmFsdWUsIGtleSkge1xuICAgICAgICB2bS5pZHMucHVzaCh2YWx1ZS5pZCk7XG4gICAgICB9KTtcbiAgICAgIHZtLiRzZXQodGhpcywgJ3ZhbHVlJywgdm0uaWRzKTtcbiAgICAgIHZtLiRlbWl0KCd3cGNmdG8tZ2V0LXZhbHVlJywgdm0uaWRzKTtcbiAgICB9LFxuICAgIGNhbGxGdW5jdGlvbjogZnVuY3Rpb24gY2FsbEZ1bmN0aW9uKGZ1bmN0aW9uTmFtZSwgaXRlbSwgbW9kZWwpIHtcbiAgICAgIGZ1bmN0aW9uTmFtZShpdGVtLCBtb2RlbCk7XG4gICAgfSxcbiAgICBjb250YWluc09iamVjdDogZnVuY3Rpb24gY29udGFpbnNPYmplY3Qob2JqLCBsaXN0KSB7XG4gICAgICB2YXIgaTtcblxuICAgICAgZm9yIChpID0gMDsgaSA8IGxpc3QubGVuZ3RoOyBpKyspIHtcbiAgICAgICAgaWYgKGxpc3RbaV1bJ2lkJ10gPT09IG9ialsnaWQnXSkge1xuICAgICAgICAgIHJldHVybiB0cnVlO1xuICAgICAgICB9XG4gICAgICB9XG5cbiAgICAgIHJldHVybiBmYWxzZTtcbiAgICB9LFxuICAgIHJlbW92ZUl0ZW06IGZ1bmN0aW9uIHJlbW92ZUl0ZW0oaW5kZXgpIHtcbiAgICAgIHRoaXMuaXRlbXMuc3BsaWNlKGluZGV4LCAxKTtcbiAgICB9XG4gIH0sXG4gIHdhdGNoOiB7XG4gICAgaXRlbXM6IGZ1bmN0aW9uIGl0ZW1zKCkge1xuICAgICAgdGhpcy51cGRhdGVJZHMoKTtcbiAgICB9XG4gIH1cbn0pOyJdfQ==
},{}]},{},[1])