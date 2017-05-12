/**
 * Created by lp on 10/05/2017.
 */

import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

const state = {
  isEditingPoll: false,
  poll: {},
  variants: {},
  formAction: '',
};

const getters = {
  isEditingPoll(state) {
    return state.isEditingPoll
  },
  poll (state) {
    return state.poll;
  },
  formAction (state) {
    return state.formAction;
  },
  variants (state) {
    return state.variants;
  }
};

const mutations = {
  pollIsEditing(state) {
    state.isEditingPoll = true;
  },
  setPoll(state, poll) {
    poll['pages'].forEach(page => {
      page['questions'].forEach(question => {
        question['variant'] = {...question['propositions'][0]['variant']};
        question['propositions'].forEach(proposition => {
          delete proposition['variant'];
        });
      });
    });

    state.poll = {...poll};
  },
  setVariants (state, variants) {
    state.variants = {...variants};
  },
  setFormAction(state, formAction) {
    state.formAction = formAction;
  },
};

export default new Vuex.Store({
  state,
  getters,
  mutations
})