<template>
  <div class="register-style">
    <div class="register-form">
      <form>
        <h2 class="text-center">Registrarse en el sistema</h2>
        <div class="form-group">
          <input
            v-model="name"
            type="text"
            class="form-control"
            placeholder="Username"
            required="required"
          />
        </div>
        <div class="form-group">
          <input
            v-model="email"
            type="text"
            class="form-control"
            placeholder="Email"
            required="required"
          />
        </div>
        <div class="form-group">
          <input
            v-model="password"
            type="password"
            class="form-control"
            placeholder="Password"
            required="required"
          />
        </div>
        <br />
        <div class="form-group">
          <button class="btn btn-primary btn-block" v-on:click.prevent="registro">Registrarse</button>
        </div>¿Ya posees una cuenta?
        <a href="/login" class="pull-right">Identifícate</a>
      </form>
    </div>
  </div>
  
</template>
<script>
import axios from "axios";

export default {
  components: {},
  data() {
    return {
      name: "",
      email: "",
      password: ""
    };
  },
  methods: {
    registro() {
      let me = this;

      const requestBody = {
        name: me.name,
        email: me.email,
        password: me.password
      };

      let config = {
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        }
      };

      const url = this.apiUrl;
      console.log(requestBody);
      axios
        .post(url + "/api/register", requestBody)
        .then(function(response) {
          console.log(response.data.success.token);
          const responseToken = response.data.success.token;
          localStorage.authToken = responseToken;
        })
        .catch(function(error) {
          console.log(error);
        });
    }
  }
};
</script>
<style>
.register-style {
  background: rgba(195, 24, 201, 0.39);
}

.register-form {
  width: 340px;
  margin: 50px auto;
  margin-bottom: 15px;
  background: rgb(36, 26, 26);
  box-shadow: 0px 20px 20px rgba(0, 0, 0, 0.452);
  padding: 30px;
}
.register-form {
  width: 450px;
  margin: 50px auto;
}

.register-form h2 {
  margin: 0 0 50px;
}
.register-control,
.btn {
  min-height: 38px;
  border-radius: 2px;
}
.btn {
  font-size: 15px;
  font-weight: bold;
}
</style>
