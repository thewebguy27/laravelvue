<template>
    <div>
        <div v-if="hasComments">
            <h5>All comments</h5>
            <p v-for="comment in comments" v-bind:key="comment.id">
                {{comment.comment}}
                <span class=" text-muted">{{comment.created_at}}</span>
            </p>
        </div>
    <form v-on:submit.prevent="addComment()">
        <div class=" form-group">
            <label for="comment">Add Comment</label>
            <input type="text" class=" form-control" placeholder="Write something..." v-model="comment">
        </div>
        <div class=" text-center mt-3">
            <button type="submit" class=" btn btn-info">Add comment</button>
        </div>
    </form>
    </div>
   
</template>

<script>
export default {

    mounted(){
        this.fetchComments()
    },
   
    props:['articleid'],
    
   
    data(){
        return{
            comments:[],
            comment:'',
            articleidd:this.articleid,
            hasComments:false
        }
    },
    methods:{
        addComment(){
            axios.post(' api/comments',{
                comment:this.comment,
                articleidd:this.articleid
            }).then(res=>console.log(res.data))
            .then(data=>{
                this.comment='',
                alert('Comment added')
                this.fetchComments()
            })
            // this.$emit('comments',this.comments)
        },
        fetchComments(){
            axios.get(`api/articlecomments/${this.articleidd}`).then(res=>{
                this.hasComments=true
                this.comments=res.data.data
            })
            .catch(err=>{
                if(err){
                    this.hasComments=false
                }
            })
        }
    }
}
</script>