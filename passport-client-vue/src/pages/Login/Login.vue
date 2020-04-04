<template>
  <div class="login-style">
    <div class="login-form">
      <h2 class="text-center">Log in</h2>

      <h3>{{ email }}</h3>
      <h3>{{password}}</h3>

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
      <span v-if="loginError" class="label label-danger">No puede acceder al sistema</span>

      <div class="form-group">
        <button class="btn btn-primary btn-block" v-on:click.prevent="loginUser">Log in</button>
      </div>
      <div class="clearfix">
        <label class="pull-left checkbox-inline">
          <input type="checkbox" /> Remember me
        </label>
        <a href="#" class="pull-right">Forgot Password?</a>
      </div>
      <br />¿No posees una cuenta?
      <a href="/register" class="pull-right">Regístrate</a>
    </div>
  </div>
</template>
<script>
import axios from "axios";

export default {
  components: {},
  data() {
    return {
      email: "cliente2@mail.com",
      password: "secret",
      loginError: false
    };
  },
  methods: {
    loginUser() {
      let me = this;

      const requestBody = {
        email: me.email,
        password: me.password
      };

      localStorage.authToken = "";

      console.log(requestBody);

      const url = this.apiUrl;
      console.log(requestBody);
      axios
        .post(url + "/api/login", requestBody)
        .then(function(response) {
          console.log(response);
          const responseToken = response.data.success.token;
          localStorage.authToken = responseToken;
          //me.getUser();
          const checkStatus = response.status;
          if (checkStatus == 200) {
            window.location.href = "dashboard";
          }
        })
        .catch(function(error) {
          console.log(error);
          me.loginError = true;
          me.resetUserData();
        });

      console.log(localStorage.getItem("authToken"));
    },
    resetUserData() {
      this.email = "";
      this.password = "";
    },
    getUser() {
      let me = this;
      let config = {
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json",
          Authorization: "Bearer " + localStorage.getItem("authToken")
        }
      };

      const url = this.apiUrl;

      axios
        .get(url + "/api/user", config)
        .then(function(response) {
          console.log("xd");
          console.log(response);

          const checkStatus = response.status;
          if (checkStatus == 200) {
            window.location.href = "dashboard";
          } else {
            alert("Usuario no válido");
          }
        })
        .catch(function(error) {
          console.log(error);
          alert("Usuario no válido");
        });
    }
  },
  mounted() {
    console.log(this.apiUrl);
  }
};
</script>
<style>

.login-style{
    background: rgba(248, 50, 255, 0.39);
}

.login-form {
  width: 340px;
  margin: 50px auto;
  margin-bottom: 15px;
  background: rgb(36, 26, 26);
  box-shadow: 0px 20px 20px rgba(0, 0, 0, 0.452);
  padding: 30px;
}
.login-form form {
  margin-bottom: 15px;
  background: rgba(36, 26, 26, 0.733);
  box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
  padding: 30px;
}
.login-form h2 {
  margin: 0 0 15px;
}
.form-control,
.btn {
  min-height: 38px;
  border-radius: 2px;
}
.btn {
  font-size: 15px;
  font-weight: bold;
}
</style>
