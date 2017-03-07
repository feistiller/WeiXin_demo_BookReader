// pages/user/index.js
var temp_data;
Page({
  data: {
    items:[]
  },
  onLoad: function (options) {
    // 页面初始化 options为页面跳转所带来的参数
    console.log(wx.getStorageSync('usertoken'))
    if (wx.getStorageSync('usertoken') == '') {
      wx.navigateTo({
        url: './login'
      })
    } else {
      // 页面初始化发送请求，验证是否登录
      wx.request({
        url: 'http://localhost:8000/API/login', //仅为示例，并非真实的接口地址
        data: {
          'token': wx.getStorageSync('usertoken')
        },
        method: 'POST',
        header: {
          'content-type': 'application/x-www-form-urlencoded'
        },
        success: function (res) {
          // console.log(wx.getStorageSync('usertoken'))
          console.log(res.data)
          if (res.data.status == 1) {
            // 页面初始化发送请求，获取用户列表
            wx.request({
              url: 'http://localhost:8000/API/books', //仅为示例，并非真实的接口地址
              data: {
                'token': wx.getStorageSync('usertoken')
              },
              method: 'POST',
              header: {
                'content-type': 'application/x-www-form-urlencoded'
              },
              success: function (res) {
                console.log(res.data.data[0])
                if (res.data.status == 1) {
                  console.log(res.data.data[0])
                  temp_data = res.data.data[0]
                } else {
                  wx.showToast({
                    title: res.data.message,
                    icon: 'loading',
                    duration: 1000
                  })
                }
              }
            })
          } else {
            wx.showToast({
              title: res.data.message,
              icon: 'loading',
              duration: 1000,
              success: function (res) {
                wx.redirectTo({
                  url: './login'
                })
              }
            })
          }
        }
      })
    }
  },
  onReady: function () {
    // 页面渲染完成
    this.setData({
      items: temp_data
    })
    console.log(items)
  },
  onShow: function () {
    // 页面显示
  },
  onHide: function () {
    // 页面隐藏
  },
  onUnload: function () {
    // 页面关闭
  }
})