<template>
    <div class="card _box_shadow mb-5 mb-xl-10">

        <Form @submit.prevent="handleSubmit('form')" ref="form" :model="form" :rules="formValidate" class="form w-100"
            label-position="top">
            <Row :gutter="16">

                <Col span="12">
                <div class="d-flex flex-column fv-row mb-3">
                    <FormItem class="form-label fs-6 fw-bolder text-dark" label="Referral Email" prop="email">
                        <Input size="large" v-model="form.email" class="custom_inp" type="text" placeholder="Referral Email"
                            autocomplete="off">
                        </Input>
                    </FormItem>
                </div>
                </Col>

                <Col span="24">
                <div class="text-left">

                    <Button :loading="isLoading" shape="circle" style="height: 51px;" :disabled="isLoading"
                        @click="handleSubmit('form')" size="large" type="primary">
                        {{ isLoading ? 'Please wait ...' : 'Send Referral' }}
                    </Button>

                </div>
                </Col>

            </Row>
        </Form>

    </div>
</template>

<script>

export default {
    name: 'Referral',
    data() {
        let form = {
            email: null
        }
        const formValidate = {
            email: [
                { required: true, type: 'email', message: 'Please input email', trigger: 'blur' },
                { max: 255, message: 'Email must not be greater than 255 characters long', trigger: 'blur' },
            ]
        };

        return {
            form,
            formValidate
        }
    },
    methods: {
        handleSubmit(name) {
            this.$refs[name].validate(async (valid) => {
                if (valid) {
                    this.isLoading = true;
                    const res = await this.callApi('POST', '/web/referral/create-referral', this.form);
                    if (res.status == 200) {
                        this.$refs[name].resetFields();
                    }
                    this.isLoading = false;
                }
            })
        },
        handleReset(name) {
            this.$refs[name].resetFields();
        },
    },
}
</script>
