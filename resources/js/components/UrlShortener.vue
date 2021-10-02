<template>
    <form>
        <div class="input-group input-group-lg">
            <input type="text" v-model.trim="link" class="form-control" placeholder="Paste your link here..." aria-label="Paste your link here..." aria-describedby="button-addon">
            <div class="input-group-append">
                <input type="text" v-model.trim="customAlias" class="form-control" placeholder="Custom link (optional)" aria-label="Custom link (optional)" aria-describedby="button-addon">
                <b-form-datepicker v-model.trim="expiredAt" placeholder="Expiration date (optional)"></b-form-datepicker>
                <button class="btn btn-outline-secondary" type="button" id="button-addon" @click.prevent="shorten()">Shorten</button>
            </div>
        </div>
        <p v-if="shortLink">
            <a v-bind:href="shortLink" target="_blank">{{ shortLink }}</a>
        </p>
        <b-table striped hover :items="shortLinks"></b-table>
    </form>
</template>

<script>
export default {
    data() {
        return {
            link: '',
            customAlias: '',
            expiredAt: '',
            shortLinks: [],
            shortLink: '',
        }
    },
    methods: {
        shorten() {
            let data = {
                'link': this.link,
                'custom_alias': this.customAlias,
                'expired_at': this.expiredAt
            };

            axios
                .post('/api/shorten', data)
                .then(res => {
                    let {data} = res.data;
                    this.shortLinks.push({
                        'Short Link': data.short_link,
                        'Link': data.link
                    })

                    this.clearFields();
                })
                .catch(err => console.log(err));
        },

        clearFields() {
            this.link = null;
            this.customAlias = null;
            this.expiredAt = null;
        }
    },
    mounted() {
        console.log('Component mounted.');
    },
};
</script>
