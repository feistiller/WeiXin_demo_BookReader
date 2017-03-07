// pages/user/login.js
Page({
  re_Register: function (e) {
    wx.navigateTo({
      url: './register',
    })
  },
  formSubmit: function (e) {
    //当点击了submit按钮后发出新的请求
    wx.request({
      url: 'http://localhost:8000/API/login', //仅为示例，并非真实的接口地址
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
          //存入缓存中
          wx.setStorage({
            key: "usertoken",
            data: res.data.data.token
          })
          wx.showToast({
            title: '登录成功',
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
  },
  data: {},
})