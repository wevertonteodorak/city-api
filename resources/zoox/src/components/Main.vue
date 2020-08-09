<template>
  <div>
    <v-app>
      <v-app-bar app class="primary">
        <v-btn text dark router to="/">Home</v-btn>
        <v-btn text dark router to="/estado">Estados</v-btn>
        <v-btn text dark router to="/cidade">Cidades</v-btn>
      </v-app-bar>
      <v-progress-linear buffer-value="0" stream :active="loading" color="purple" indeterminate value="15"></v-progress-linear>
      
      <v-main class="mt-0 pt-0">
          <router-view></router-view>
        
      </v-main>

      <v-footer app>

      </v-footer>
    </v-app>
  </div>
</template>


<script>
export default {
  name: 'Main',

  data: () => ({
    loading: false
  }),

  mounted () {
    var self = this
    this.$root.$on('loading', () => {
        self.loading = !self.loading
    });
  }
}
</script>