<template>
  <span class="text-center">
    <v-menu offset-y :close-on-content-click="false">
      <template v-slot:activator="{ on, attrs }">
        <v-btn
          text
          v-bind="attrs"
          v-on="on"
        >
          Ordenar por
        </v-btn>
      </template>
      <v-list>
        <v-list-item
          v-for="(item, index) in items"
          :key="index"
          @click="setOrder(item)"
        >
          <v-list-item-title>{{ item.title }}</v-list-item-title>
          <v-list-item-action>
            <v-btn icon v-if="item.value == selected.field">
              <v-icon color="grey lighten-1" v-if="selected.direction=='ASC'">mdi-sort-ascending</v-icon>
              <v-icon color="grey lighten-1" v-if="selected.direction=='DESC'">mdi-sort-descending</v-icon>
            </v-btn>
          </v-list-item-action>
        </v-list-item>
      </v-list>
    </v-menu>
  </span>
</template>

<script>
  export default {
    props: {
        items: {
            type: Array,
            default: () => {return []}
        },
        selected: {
            type: Object,
            default: () => {return {field: 'name', direction: 'ASC'}}
        }
    },
    data: () => ({
        directions: ['ASC', 'DESC']
    }),
    methods: {
      setOrder (item) {
        if (item.value == this.selected.field) {
          var index = this.directions.indexOf(this.selected.direction)
          this.selected.direction = this.directions[1-index]
        } else {
          this.selected.field = item.value
          this.selected.direction = 'ASC'
        }
        this.$emit('order-by', this.selected)
      }
    }
  }
</script>