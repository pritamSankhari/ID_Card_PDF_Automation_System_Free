


<!-- FOOTER -->
	<script type="text/javascript">
		let navToggleStatus = false
		
		let navToggle = function(){
			if(navToggleStatus == true){

				$('.btn-nav-menu-off').hide()
				$('.btn-nav-menu-on').show()
				// $('nav .list-group').css({'left':'-250px','transition':'1s'})
				$('.sliding-bar').css({'left':'-250px','transition':'1s'})
				// $('.main').css({'left':'0px','transition':'1s'})
				
				navToggleStatus=false
			}
			else if(navToggleStatus == false){

				// $('.main').css({'left':'250px','transition':'1s'})
				// $('nav .list-group').css({'left':'0px','transition':'1s'})
				$('.sliding-bar').css({'left':'0px','transition':'1s'})

				$('.btn-nav-menu-on').hide()
				$('.btn-nav-menu-off').show()

				navToggleStatus=true

			}
		}

		$('.btn-nav-menu-on').on('click',function(){
			navToggle()
		})
		$('.btn-nav-menu-off').on('click',function(){
			navToggle()
		})

		$("#search_input").on('input',function(){
			console.log($("#search_input").val())

			if($("#search_input").val() == "" || $("#search_input").val() == " ") {
				$(".search-results").html(' ')	
				// $(".search-results").html('No Such Record')	
				return
			}
			$.post(
				'search_by_contact_no.php',
				{
					'mobile':$("#search_input").val()
				},
				function(data){
					
					data = JSON.parse(data)
					// console.log(data)

					let result_in_html = ""
					$(".search-results").html(result_in_html)

					for(let i=0;i<data.length;i++){

						let link="<a class='search-result-employee text-dark' href='employee.php?emp_data_id="
							+data[i].id
							+"'>"
							+"<span><img src='"
							+data[i].image
							+"'></span>"
							+"<span class='result-name'>"
							+data[i].name
							+"</span>"
							+"</a>";

						// let link = "<div class='search-result-employee'><a class='text-dark' href='employee.php?emp_data_id="+data[i].id+"'>"+data[i].name+"</a></div>";

						result_in_html+=link
						
					}
					$(".search-results").append(result_in_html)
				}
			)
		})
	</script>
	</div>
</body>
</html>
<!-- FOOTER -->