<template>
    <v-footer dark padless class="d-block footer">
        <v-spacer class="text-center">
            <img src="../assets/Armedia-logo.png" alt="logo" width="200px">
            <p class="mb-0 py-3"><strong>&copy; {{ new Date().getFullYear() }}</strong> - Armedia Online BookStore</p>
        </v-spacer>
    </v-footer>
</template>
<script>
export default {
  data: () => ({
    // icons: [
    //   'mdi-facebook',
    //   'mdi-twitter',
    //   'mdi-linkedin',
    //   'mdi-instagram'
    // ]
  })
}
</script>
<style>
    .footer{
        margin-top: 15px;
        width:100%;
    }
</style>
