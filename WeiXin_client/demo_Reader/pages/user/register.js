// pages/user/register.js
Page({
  data: {},
  formSubmit: function (e) {
    //对于是否两次密码输入一致进行判断
    if (e.detail.value.password == e.detail.value.re_password) {
      //当点击了submit按钮后发出新的请求
      wx.request({
        url: 'http://localhost:8000/API/register', //仅为示例，并非真实的接口地址
        data: {
          'username': e.detail.value.username,
          'password': e.detail.value.password,
        },
        method: 'POST',
        header: {
          'content-type': 'application/x-www-form-urlencoded'
        },
        success: function (res) {
          console.log(res.data)
          if (res.data.status == 1) {
            wx.showToast({
              title: res.data.message+",请返回登录。",
              icon: 'success',
              duration: 2000
            })
          } else {
            wx.showToast({
              title: res.data.message,
              icon: 'loading',
              duration: 2000
            })
          }
        }
      })
    } else {
      wx.showToast({
        title: "两次输入密码不一致，请检查",
        icon: 'loading',
        duration: 2000
      })
    }
  },
})