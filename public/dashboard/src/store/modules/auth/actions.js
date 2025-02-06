import axios from "axios";

export default {
  async login(context, payload) {
    context.dispatch('auth',{
      ...payload
    })
  },
  async auth(context,payload){
    try {
      const response = await axios.post(
        'http://127.0.0.1:8000/api/admin/login',
        {
          email: payload.email,
          password: payload.password
        }
      );

      const responseData = response.data;
      console.log( responseData.user.token,responseData);
      localStorage.setItem('token',responseData.user.token)
      localStorage.setItem('userId',responseData.user.id)
      // Store the user data or perform any necessary actions
      // For example, you can commit a mutation to update the user state
      context.commit('setUser', {
        token: responseData.user.token,
        userId: responseData.user.id,
       
      });
      
    } catch (error) {
      console.log(error.message);

      // You can handle the error here or re-throw it to be caught higher up
      throw error;
    }
  },
  tryLogin(context){
   const token = localStorage.getItem('token');
   const userId = localStorage.getItem('userId');
   if(token && userId)
   {
    context.commit('setUser', {
      token: token,
      userId: userId,
     
    });
   }


  }

};
