<footer class="mainfooter" role="contentinfo">
  <div class="footer-middle">
      <div class="container">
          <div class="row">
              <div class="col-md-4 col-sm-6">
                  <!--Column2-->
                  <div class="footer-pad">
                      <h4>Навигация</h4>
                      <ul class="list-unstyled">
                          <li><a href="{{ route('home') }}">Главная</a></li>
                          <li><a href="{{ route('categories.show', ['slug' => 'salon']) }}">Салон</a></li>
                          <li><a href="{{ route('categories.show', ['slug' => 'dvigatel']) }}">Двигатель</a></li>
                          <li><a href="{{ route('categories.show', ['slug' => 'optika']) }}">Оптика</a></li>
                          <li><a href="{{ route('categories.show', ['slug' => 'kuzovnye-detali']) }}">Кузовные детали</a></li>
                          <li><a href="{{ route('categories.show', ['slug' => 'podveska']) }}">Подвеска</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6">
                    <!--Column1-->
                    <div class="footer-pad">
                        <h4>Информация</h4>
                        <ul class="list-unstyled">
                            <li><a href="{{ route('about') }}">О нас</a></li>
                            <li><a href="{{ route('delivery') }}">Условия доставки</a></li>
                            <li><a href="{{ route('contacts') }}">Контакты</a></li>
                        </ul>
                    </div>
                </div>
              <div class="col-md-3">
                  <h4>Следуйте за нами</h4>
                  <ul class="social-network social-circle">
                      <li><a href="#" class="icoTelegram" title="Telegram"><i class="fab fa-telegram-plane"></i></a></li>
                      <li><a href="#" class="icoVk" title="Vk"><i class="fab fa-vk"></i></a></li>
                      <li><a href="#" class="icoWhatsapp" title="WhatsApp"><i class="fab fa-whatsapp"></i></a></li>
                  </ul>
              </div>
          </div>
          <div class="row">
              <div class="col-md-12 copy">
                  <p class="text-center">&copy; Copyright 2025 - AutoParts. Все права защищены.</p>
              </div>
          </div>
      </div>
  </div>
</footer>