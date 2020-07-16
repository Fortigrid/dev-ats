<template>

 <div>
        <h1>Dashboard</h1>
    <div class="container">
        <div class="col-md-10" v-on:load="Users()">
            <template v-for="cats in users">
			<div>{{cats.id}}</div>
			</template>
        </div>
    </div>
	</div>
</template>

<script>
    export default {
	   name:'LoginComponent',
	   data () {
           return {
              cnames:"",
              users:{},
              tokens:""
               }
                 },
                created () {
                        this.loading = true;
						this.Users();
                },
				 methods: {
                        Users(){
                      
                        this.cnames=this.$route.params.cname;
                        axios.get("http://localhost:8000/api/auth/dash")
                        .then((response) => {
                                                this.loading = false;
                                                this.users=response.data;

                                                })
                        }
						
                },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
