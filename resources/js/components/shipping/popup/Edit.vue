<template>
<!-- Modal -->
    <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true" v-if="consumer_array">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form @submit.prevent="$parent.updateorder()">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" v-model="$parent.form.status">
                            <option
                                v-for="(cat) in $parent.orders_status" :key="cat"
                                :value="cat"
                                :selected="cat == $parent.form.status">{{ cat}}</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</template>
