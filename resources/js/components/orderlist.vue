<template>
<tr>
    <td>{{item}}</td>
    <td>{{quantity}} 
        <button @click="inc"><i class="fas fa-arrow-down"></i></button>
        <button @click="dec"><i class="fas fa-arrow-up"></i></button>
    </td>
    <td>{{price}}</td>
    <td>
        <button @click="del">Delete</button>
    </td>
</tr>
</template>

<script>
  export default {
    methods: {
      inc() {
        this.$emit('update', this.item, this.quantity+1 );
      },
      dec() {
        this.$emit('update', this.item, this.quantity-1 );
      },
      del() {
        this.$emit('delete', this.item);
      }
    },
    props: ['item','quantity','price']
  }
</script>