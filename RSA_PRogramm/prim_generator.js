const first_primes_list = [3,5,7,11,13,17,19,23,29,31,37,41,43,47,53,59,61,67,71,73,79,83,89,97
    ,101,103,107,109,113,127,131,137,139,149,151,157,163,167,173,179
    ,181,191,193,197,199,211,223,227,229,233,239,241,251,257,263,269
    ,271,277,281,283,293,307,311,313,317,331,337,347,349,353,359,367
    ,373,379,383,389,397,401,409,419,421,431,433,439,443,449,457,461
    ,463,467,479,487,491,499,503,509,521,523,541,547,557,563,569,571
    ,577,587,593,599,601,607,613,617,619,631,641,643,647,653,659,661
    ,673,677,683,691,701,709,719,727,733,739,743,751,757,761,769,773
    ,787,797,809,811,821,823,827,829,839,853,857,859,863,877,881,883
    ,887,907,911,919,929,937,941,947,953,967,971,977,983,991,997]

// Javascript program Miller-Rabin primality test
 
// Utility function to do
// modular exponentiation.
// It returns (x^y) % p
function power(x, y, p)
{
     
    // Initialize result
    let res = 1;
     
    // Update x if it is more than or
    // equal to p
    x = x % p;
    while (y > 0)
    {
         
        // If y is odd, multiply
        // x with result
        if (y & 1)
            res = (res*x) % p;
 
        // y must be even now
        y = y>>1; // y = y/2
        x = (x*x) % p;
    }
    return res;
}
 
// This function is called
// for all k trials. It returns
// false if n is composite and
// returns false if n is
// probably prime. d is an odd
// number such that d*2<sup>r</sup> = n-1
// for some r >= 1
function miillerTest(d, n)
{
     
    // Pick a random number in [2..n-2]
    // Corner cases make sure that n > 4
    let a = 2 + Math.floor(Math.random() * (n-2)) % (n - 4);
 
    // Compute a^d % n
    let x = power(a, d, n);
 
    if (x == 1 || x == n-1)
        return true;
 
    // Keep squaring x while one
    // of the following doesn't
    // happen
    // (i) d does not reach n-1
    // (ii) (x^2) % n is not 1
    // (iii) (x^2) % n is not n-1
    while (d != n-1)
    {
        x = (x * x) % n;
        d *= 2;
 
        if (x == 1)    
            return false;
        if (x == n-1)
              return true;
    }
 
    // Return composite
    return false;
}
 
// It returns false if n is
// composite and returns true if n
// is probably prime. k is an
// input parameter that determines
// accuracy level. Higher value of
// k indicates more accuracy.
function isPrime( n, k)
{
     
    // Corner cases
    if (n <= 1 || n == 4) return false;
    if (n <= 3) return true;
 
    // Find r such that n =
    // 2^d * r + 1 for some r >= 1
    let d = n - 1;
    while (d % 2 == 0)
        d /= 2;
 
    // Iterate given number of 'k' times
    for (let i = 0; i < k; i++)
        if (!miillerTest(d, n))
            return false;
 
    return true;
}
 



function findPrim(n) {
    while (true) {
        
        let prime_candidate = getLowLevelPrime(n);
        if (!isPrime(prime_candidate, 4)) {
            continue;
        }
        else {return n}
    }
  }













  




  function expmod( base, exp, mod ){
    if (exp == 0) return 1;
    if (exp % 2 == 0){
      return Math.pow( expmod( base, (exp / 2), mod), 2) % mod;
    }
    else {
      return (base * expmod( base, (exp - 1), mod)) % mod;
    }
  }

  function nBitRandom(n)
  {
      // Returns a random number
      // between 2**(n-1)+1 and 2**n-1'''
      let max =  2**n-1
      let min = 2**(n-1)+1
      return Math.floor(Math.random() * (max - min) + min)
  }
  
  
  function getLowLevelPrime(n)
  {
      // Generate a prime candidate divisible
      // by first primes
     
      //  Repeat until a number satisfying
      //  the test isn't found
      while (true)
      {
          //  Obtain a random number
          prime_candidate = nBitRandom(n) 
     
          for (let divisor of first_primes_list)
          {
              if (prime_candidate % divisor == 0
              && divisor**2 <= prime_candidate)
                  break
              //  If no divisor found, return value
              else
                  return prime_candidate 
          }
      }
  }
   
  
  function expmod( base, exp, mod ){
    if (exp == 0) return 1;
    if (exp % 2 == 0){
      return Math.pow( expmod( base, (exp / 2), mod), 2) % mod;
    }
    else {
      return (base * expmod( base, (exp - 1), mod)) % mod;
    }
  }
  
  
  function isMillerRabinPassed(miller_rabin_candidate)
  {
      // Run 20 iterations of Rabin Miller Primality test
     
      let maxDivisionsByTwo = 0
      let evenComponent = miller_rabin_candidate-1
     
      while (evenComponent % 2 == 0)
      {
          evenComponent >>= 1
          maxDivisionsByTwo += 1
      }
   
      function trialComposite(round_tester)
      {
          if (expmod(round_tester, evenComponent, 
                 miller_rabin_candidate) == 1 )
              return false
          for (var i = 0; i < (maxDivisionsByTwo); i++)
          {
              if (expmod(round_tester, 2**i * evenComponent,
                     miller_rabin_candidate) 
              == miller_rabin_candidate-1)
                  return false
          }
          return true
      }
       
      // Set number of trials here
      let numberOfRabinTrials = 20
      for (var i = 0; i < (numberOfRabinTrials) ; i++)
      {
          let round_tester = Math.random() * (miller_rabin_candidate - 2) + 2;
           
          if (trialComposite(round_tester))
              return false
      }
      return true
  }
  
  //legnth of number
  
  function findPrim(n) {
      while (true) {
          
          let prime_candidate = getLowLevelPrime(n);
          if (!isMillerRabinPassed(prime_candidate)) {
              continue;
          }
          else {return n}
      }
    }
