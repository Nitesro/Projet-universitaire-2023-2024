const pingouin =document.getElementById('pingouin');
const eau      =document.getElementById('eau'     );
const poisson      =document.getElementById('poisson'     );
const phoque      =document.getElementById('phoque'     );
let score=0;



function random(min, max) {
    return Math.random() * (max - min) + min;
    }

document.addEventListener('keydown',function(event){
  console.log('Touche appuyée',event.code);
  console.log('pingouin.style.top:',pingouin.style.top);
  let top=parseInt(pingouin.style.top);
  if(event.code ==="ArrowUp"  ){top-=30;}
  if(event.code ==="ArrowDown"){top+=30;}
//  if (top ==420){top= 390;}
//  if (top ==-30){top= 0;}
if(top<0     ){top=0;}
if(top>450-60){top=450-60;}
  pingouin.style.top=top+'px';
});

window.setInterval(function(){
    const poisson=document.createElement('img');
    poisson.src='../asset/poisson.svg';
    poisson.className='poisson';
    eau.append(poisson);
    poisson.style.top = random(18, 432) + 'px';
    window.getComputedStyle(poisson).top;
    poisson.style.left="-40px";
    window.setTimeout(() => {
        const rectPingouin=pingouin.getBoundingClientRect();
        const rectPoisson =poisson.getBoundingClientRect();
        if(rectPingouin.bottom>rectPoisson.top && rectPingouin.top<rectPoisson.bottom)
        {
           console.log('Miam');
           score++;
           document.getElementById('score').textContent=score
           poisson.remove();

        }
        
    }, 1650);
    
    window.setTimeout(() => {
        poisson.remove();
        }, 2000);


      
    // if( poisson.style.top<pingouin.style.top + 1 && poisson.style.bottom > pingouin.style.bottom -1)
    //{console.log('Miam');}



    },500);

    window.setInterval(function(){
        const phoque=document.createElement('img');
        phoque.src='../asset/phoque.svg';
        phoque.className='phoque';
        eau.append(phoque);
        phoque.style.top = random(450-117) + 'px';
        window.getComputedStyle(phoque).top;
        phoque.style.left="-40px";
        window.setTimeout(() => {
            const rectPingouin=pingouin.getBoundingClientRect();
            const rectPhoque =phoque.getBoundingClientRect();
            if(rectPingouin.bottom>rectPhoque.top && rectPingouin.top<rectPhoque.bottom)
            {
                alert('Mangé par le phoque!');
                phoque.remove();
              
    
            }
            
        }, 1650);
        window.setTimeout(() => {
            phoque.remove();
            }, 2000);
    
    
    
        },4000);
    
