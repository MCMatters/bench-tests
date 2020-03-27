<template>
    <table class="table table-striped table-bordered table-sm" id="benchmark-result">
        <thead class="thead-inverse">
        <tr>
            <th class="cursor-pointer" @click.prevent="sort('name')">Test</th>
            <th class="cursor-pointer" @click.prevent="sort('min')">Min time, s</th>
            <th class="cursor-pointer" @click.prevent="sort('max')">Max time, s</th>
            <th class="cursor-pointer" @click.prevent="sort('avg')">Avg time, s</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="result in sortedResults">
            <td><b>{{ result.name }}</b></td>
            <td>{{ result.min }}</td>
            <td>{{ result.max }}</td>
            <td>{{ result.avg }}</td>
        </tr>
        </tbody>
    </table>
</template>

<script>
export default {
  props: {
    results: {
      type: Array,
      required: true,
    },
  },
  data() {
    return {
      sortBy: null,
      sortDir: null,
    };
  },
  computed: {
    sortedResults() {
      return this.results.sort((a, b) => {
        let c;
        let d;

        if (this.sortDir === 'asc') {
          c = a;
          d = b;
        } else {
          c = b;
          d = a;
        }

        if (c[this.sortBy] > d[this.sortBy]) {
          return 1;
        }

        if (c[this.sortBy] < d[this.sortBy]) {
          return -1;
        }

        return 0;
      });
    },
  },
  methods: {
    sort(column) {
      if (this.sortBy === column) {
        this.sortDir = this.sortDir === 'asc' ? 'desc' : 'asc';
      } else {
        this.sortDir = 'asc';
        this.sortBy = column;
      }
    },
  },
};
</script>

<style>
    .cursor-pointer {
        cursor: pointer !important;
    }
</style>
