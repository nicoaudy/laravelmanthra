<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.min.css">
​
<div id="manthra">

     <form action="#" @submit.prevent="handleSubmit">
          <div class="container">
               <div class="columns box">
                    <div class="column"></div>
                    <div class="column is-four-fifths ">
                         <div class="columns">
                              <div class="column">
                                   <center>@{{ welcome }}</center>
                              </div>
                         </div>
                         <div class="columns">
                              <div class="column">
                                   <div class="field">
                                        <label class="label">Model Name<sup style="color:red">*</sup></label>
                                        <div class="control">
                                             <input class="input" type="text" v-model="model" placeholder="eg: Post">
                                        </div>
                                   </div>
                              </div>
                              <div class="column">
                                   <div class="field">
                                        <label class="label">Model Namespace</label>
                                        <div class="control">
                                             <input class="input" type="text" v-model="model_namespace"
                                                  placeholder="eg: Models">
                                        </div>
                                   </div>
                              </div>
                         </div>
                         <div class="columns">
                              <div class="column">
                                   <label class="label">Fields<sup style="color:red">*</sup></label>
                              </div>
                              <div class="column">
                                   <div class="field is-right" style="float: right">
                                        <a class="button is-link" @click="addMoreFields">Add Field</a>
                                   </div>
                              </div>
                         </div>
                         <div class="columns" v-for="(field, i) in fields">
                              <div class="column">
                                   <div class="columns">
                                        <div class="column">
                                             <div class="control">
                                                  <input class="input" type="text" v-model="field.name"
                                                       placeholder="Field Name">
                                             </div>
                                        </div>
                                        <div class="column">
                                             <div class="control">
                                                  <div class="select is-primary">
                                                       <select v-model="field.type">
                                                            <option :value="type" v-for="type in types">@{{ type }}
                                                            </option>
                                                       </select>
                                                  </div>
                                             </div>
                                        </div>
                                        <div class="column">
                                             <div class="control">
                                                  <a class="button is-danger" @click="removeFields(i)">X</a>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </div>
                         <div class="columns">
                              <div class="column">
                                   <div class="field">
                                        <label class="label">Controller Namespace</label>
                                        <div class="control">
                                             <input class="input" type="text" v-model="controller_namespace"
                                                  placeholder="eg: Admin">
                                        </div>
                                   </div>
                              </div>
                         </div>
                         <div class="columns">
                              <div class="column">
                                   <div class="field">
                                        <label class="label">View Path</label>
                                        <div class="control">
                                             <input class="input" type="text" v-model="view_path"
                                                  placeholder="eg: admin">
                                        </div>
                                   </div>
                              </div>
                         </div>
                         <div class="columns">
                              <div class="column">
                                   <div class="field">
                                        <label class="label">Route Group</label>
                                        <div class="control">
                                             <input class="input" type="text" v-model="route_group"
                                                  placeholder="eg: admin">
                                        </div>
                                   </div>
                              </div>
                         </div>
                         <div class="columns">
                              <div class="column">
                                   <div class="field">
                                        <button class="button is-primary" type="submit"
                                             :class="loading ? 'is-loading' : null">Generate</button>
                                   </div>
                              </div>
                         </div>
                    </div>
                    <div class="column"></div>
               </div>
          </div>
     </form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.10/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.min.js"></script>
<script>
     Vue.config.devtools = true
     new Vue({
          el: '#manthra',
          data: {
               welcome: 'Manthra',
               loading: false,
               types: [
                    'string',
                    'char',
                    'varchar',
                    'date',
                    'datetime',
                    'time',
                    'timestamp',
                    'text',
                    'mediumtext',
                    'longtext',
                    'json',
                    'jsonb',
                    'binary',
                    'integer',
                    'bigint',
                    'tinyint',
                    'smallint',
                    'boolean',
                    'decimal',
                    'double',
                    'float'
               ],

               model: '',
               fields: [{name: '', type: 'string'}],
               controller_namespace: '',
               model_namespace: '',
               view_path: '',
               route_group: '',
          },
          methods: {
               addMoreFields() {
                    this.fields.push({
                         name: '',
                         type: 'string'
                    })
               },
               removeFields(i) {
                    this.fields.splice(i, 1)
               },
               async handleSubmit(){
                    this.loading = true

                    try {
                         let data = {}
                         data['model'] = this.model
                         data['fields'] = this.fields
                         data['controller_namespace'] = this.controller_namespace
                         data['model_namespace'] = this.model_namespace
                         data['view_path'] = this.view_path
                         data['route_group'] = this.route_group

                         const response = await axios.post('/manthra', data)
                         const result = await response
                         console.log(result)
                    } catch (error) {
                         this.loading = false
                         alert(error)
                    }
               }
          }
     })
</script>