<template>
    <div>
        <h2>Articles</h2>
            <form @submit.prevent="addArticle()" class=" mb-3">
                <div class=" form-group">
                    <input type="text" class=" form-control" placeholder="Tilte" v-model="article.title">
                </div>
                   <div class=" form-group">
                    <textarea  class=" form-control" placeholder="Write Something..." v-model="article.body"></textarea>
                </div>
                <button type="submit" class=" btn btn-dark btn-block">Save</button>
            </form>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a @click="fetchArticles(pagination.prev_page_url)" class="page-link" href="#">Previous</a></li>
                <li  v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a  @click="fetchArticles(pagination.next_page_url)" class="page-link" >Next</a></li>
            </ul>
            </nav>
            <div class=" card card-body mb-2" v-for="article in articles" v-bind:key="article.id">
                <h3>{{article.title}}</h3>
                <p>
                    {{article.body}}
                </p>
               <Comment v-bind:articleid="article.id"></Comment>
                <hr>
                  <button class=" btn btn-info" @click="editArticle(article)">Edit</button>
                <button class=" btn btn-danger" @click="deleteArticle(article.id)">Delete</button>
            </div>
    </div>
</template>
<script>
import Comment from './Comment.vue';

export default {
    components:{
        Comment
    },
   
     data(){
        return{
            articles:[],
            article:{
                id:'',
                title:'',
                body:''
            },
            article_id:'',
            pagination:{},
            edit:false
        }
    },
    created(){
        this.fetchArticles();
        
    },
    methods:{
        fetchArticles(page_url){    
            let vm=this;
            page_url=page_url || '/api/articles'
            axios.get(page_url)
            .then(response=>response).then(response=>{
                this.articles=response.data.data;
                // console.log(response.data.meta);
                vm.makePagination(response.data.meta,response.data.links);
            })
            .catch(err=>console.log(err))
        },
        makePagination(meta,links){
            let pagination={
                current_page:meta.current_page,
                last_page:meta.last_page,
                next_page_url:links.next,
                prev_page_url:links.prev
            }
            this.pagination=pagination;
        },
        deleteArticle(id){
            if(confirm('Are you sure?')){
                axios.delete(`api/articles/${id}`).then(res=> res.data)
                .then(data=>
                alert('Article Removed'))

                this.fetchArticles();
            }
        }, 
        addArticle(){
            // console.log(this.article);

            if(this.edit===false){
                axios.post('api/articles',{
                   
                   title:this.article.title,
                   body:this.article.body
                }).then(res=>res.data)
                .then(data=>{
                    this.article.title='';
                    this.article.body='';
                    alert('Article Added');
                    this.fetchArticles();
                });
                
            }
            else{
                axios.put(`api/articles/${this.article.id}`,{
                  title:this.article.title,
                   body:this.article.body
                }).then(res=>res.data).then(data=>{
                    this.article.title='';
                    this.article.body='';
                    alert('Article Updated');
                    this.fetchArticles();
                });
            }
        },
        editArticle(article){
            this.edit=true;
            this.article.id=article.id,
            this.article.article_id=article.id,
            this.article.title=article.title,
            this.article.body=article.body
        }
    }
}
</script>