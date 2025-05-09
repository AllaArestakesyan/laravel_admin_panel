<template>
  <div class="not-found">
    <h1>404</h1>
    <p>Oops! Page not found.</p>
    <router-link to="/" class="home-link">Go back home</router-link>
  </div>
</template>

<script>
export default {
  name: 'NotFound'
}
</script>

<style lang="scss" scoped>
.not-found {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  min-height: 80vh;
  text-align: center;
  font-family: sans-serif;
  background: #f2f4f8;
  color: #333;

  h1 {
    font-size: 6rem;
    margin: 0;
    color: #3f51b5;
  }

  p {
    font-size: 1.5rem;
    margin: 1rem 0;
  }

  .home-link {
    margin-top: 1rem;
    text-decoration: none;
    color: white;
    background: #3f51b5;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: bold;
    transition: background 0.3s;

    &:hover {
      background: #303f9f;
    }
  }
}
</style>
