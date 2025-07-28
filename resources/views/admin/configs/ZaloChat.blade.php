<script>
    class ZaloChat extends BaseClass {

        before(form) {
        }

        get title() {
            return this._title;
        }

        set title(value) {
            this._title = value;
        }

        get phone() {
            return this._phone;
        }

        set phone(value) {
            this._phone = value;
        }

        get submit_data() {
            return {
                title: this.title,
                phone: this.phone,
            }
        }
    }
</script>
