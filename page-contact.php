<?php
/*
Template Name: Contact Page
*/
get_header();
?>
<div class="min-h-screen bg-[#fff8f0] flex items-center justify-center px-4">
  <div class="w-full max-w-md bg-[#fdfaf6] rounded-2xl shadow-xl p-6 border-2 border-[#f2c57c]/50">
    
    <!-- عنوان -->
    <h2 class="text-center text-2xl font-bold mb-6 text-[#6B4C3B]">
      ارتباط با ما 🌈
    </h2>
    
    <!-- فرم -->
    <form class="space-y-4">
      <input type="text" placeholder="نام و نام خانوادگی" 
             class="w-full px-4 py-3 rounded-xl border border-[#f2c57c]/50 focus:ring-2 focus:ring-[#f2c57c] bg-white text-[#6B4C3B] placeholder-[#8B5E3C]/60">
      
      <input type="email" placeholder="ایمیل" 
             class="w-full px-4 py-3 rounded-xl border border-[#f2c57c]/50 focus:ring-2 focus:ring-[#f2c57c] bg-white text-[#6B4C3B] placeholder-[#8B5E3C]/60">
      
      <input type="text" placeholder="عنوان" 
             class="w-full px-4 py-3 rounded-xl border border-[#f2c57c]/50 focus:ring-2 focus:ring-[#f2c57c] bg-white text-[#6B4C3B] placeholder-[#8B5E3C]/60">
      
      <textarea placeholder="متن پیام" rows="5" 
                class="w-full px-4 py-3 rounded-xl border border-[#f2c57c]/50 focus:ring-2 focus:ring-[#f2c57c] bg-white text-[#6B4C3B] placeholder-[#8B5E3C]/60"></textarea>
      
      <!-- دکمه -->
      <button type="submit" 
              class="w-full bg-[#f2c57c] hover:bg-[#8B5E3C] text-[#6B4C3B] hover:text-white font-bold py-3 rounded-xl transition duration-300 shadow-md">
        ثبت و ارسال ✨
      </button>
    </form>
  </div>
</div>


<?php get_footer(); ?>
