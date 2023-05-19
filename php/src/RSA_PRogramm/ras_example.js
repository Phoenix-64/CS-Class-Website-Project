const first_primes_list = [3,5,7,11,13,17,19,23,29,31,37,41,43,47,53,59,61,67,71,73,79,83,89,97
    ,101,103,107,109,113,127,131,137,139,149,151,157,163,167,173,179
    ,181,191,193,197,199,211,223,227,229,233,239,241,251,257,263,269
    ,271,277,281,283,293,307,311,313,317,331,337,347,349,353,359,367
    ,373,379,383,389,397,401,409,419,421,431,433,439,443,449,457,461
    ,463,467,479,487,491,499,503,509,521,523,541,547,557,563,569,571
    ,577,587,593,599,601,607,613,617,619,631,641,643,647,653,659,661
    ,673,677,683,691,701,709,719,727,733,739,743,751,757,761,769,773
    ,787,797,809,811,821,823,827,829,839,853,857,859,863,877,881,883
    ,887,907,911,919,929,937,941,947,953,967,971,977,983,991,997];

const pad_seperator = 112313n;
const e = 65537n;

function euler(p, q) {
    return (p - 1n) * (q - 1n);
}

function egcd(a,b) {
    console.log(a, b);
    if (a < b) [a,b] = [b, a];
    let s = 0n, old_s = 1n;
    let t = 1n, old_t = 0n;
    let r = b, old_r = a;
    while (r != 0n) {
        let q = old_r/r;
        [r, old_r] = [old_r - q*r, r];
        [s, old_s] = [old_s - q*s, s];
        [t, old_t] = [old_t - q*t, t];
    }
    console.log("Bezout coef: ", old_s, old_t);
    console.log("GCD: ", old_r);
    console.log("Quot by GCD: ", s, t);
    // old_s is k and old_t is d
    return  old_t;
}

function nBitRandom(n)
{
    // Returns a random number
    // between 2**(n-1)+1 and 2**n-1'''
    let max =  2**n-1;
    let min = 2**(n-1)+1;
    return BigInt(Math.floor(Math.random() * (max - min) + min));
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
        prime_candidate = nBitRandom(n);
    
        for (let divisor of first_primes_list)
        {
            if (prime_candidate % BigInt(divisor) == 0n
            && BigInt(divisor)**2n <= prime_candidate)
                break;
            //  If no divisor found, return value
            else
                return prime_candidate;
        }
    }
}
   
// Javascript program Miller-Rabin primality test
// Utility function to do
// modular exponentiation.
// It returns (x^y) % p
function power(x, y, p)
{
	// Initialize result 
    // (JML- all literal integers converted to use n suffix denoting BigInt)
	let res = 1n;
	
	// Update x if it is more than or
	// equal to p
	x = x % p;
	while (y > 0n)
	{
		
		// If y is odd, multiply
		// x with result
		if (y & 1n)
			res = (res*x) % p;

		// y must be even now
		y = y/2n; // (JML- original code used a shift operator, but division is clearer)
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
    let a = 2n + BigInt(Math.floor(Math.random() * (Number(n)-2)) % (Number(n) - 4));
 
    // Compute a^d % n
    let x = power(a, d, n);
 
    if (x == 1n || x == n-1n)
        return true;
 
    // Keep squaring x while one
    // of the following doesn't
    // happen
    // (i) d does not reach n-1
    // (ii) (x^2) % n is not 1
    // (iii) (x^2) % n is not n-1
    while (d != n-1n)
    {
        x = (x * x) % n;
        d *= 2n;
 
        if (x == 1n)    
            return false;
        if (x == n-1n)
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
    if (n <= 1n || n == 4n) return false;
    if (n <= 3n) return true;
 
    // Find r such that n =
    // 2^d * r + 1 for some r >= 1
    let d = n - 1n;
    while (d % 2n == 0n)
        d /= 2n;
 
    // Iterate given number of 'k' times
    for (let i = 0n; i < k; i++)
        if (!miillerTest(d, n))
            return false;
 
    return true;
}
 
const areCoprimes = (num1, num2) => {
    const smaller = num1 > num2 ? num1 : num2;
    for(let ind = 2n; ind < smaller; ind++){
       const condition1 = num1 % ind === 0n;
       const condition2 = num2 % ind === 0n;
       if(condition1 && condition2){
          return false;
       };
    };
    return true;
 };

function findCoprime(N) {
    //max n based on N size that results in e < N
    let n = Math.log(1n + N)/Math.log(2n);
    while (true) {
        let e = nBitRandom(n);
        if (!areCoprimes(N, e)) {
            continue;
        }
        else {return e}
    }

}


function findPrim(n) {
    while (true) {
        
        let prime_candidate = getLowLevelPrime(n);
        if (!isPrime(prime_candidate, 20)) {
            continue;
        }
        else {return prime_candidate}
    }
  }


  // with 6 it is nesured that N is atleast 1050625
let n = 53;
let p = findPrim(n); //Prim Number
let q = findPrim(n); //Prim number
//let p = 11
//let q = 13
let N = p * q;
let Nphi = euler(p, q);
// 1 < e < Nphi - 1 and 
//let e = findCoprime(N)

// e and N are the public key
// d is the privat key
let d = egcd(e, Nphi);
while (d == 1n) {
    p = findPrim(n); //Prim Number
    q = findPrim(n); //Prim number
    N = p * q
    Nphi = euler(p, q);
    d = egcd(e, Nphi);
} 
let d_old = d;
//and make sure its positiv

d = d % Nphi;
if (d < 0n) {
    d = d + Nphi;
}   

let examples = [234n, 12n, 4352n, 234n, 5n, 195112313169n];

for (i in examples) {
    let c = power(examples[i], e, N);
    let m_d = power(c, d, N);
    console.log(examples[i] + "   " + m_d);
}

// m is the message m < N
let m = 7n;
// c is the encripted message
let c = power(m, e, N);

// to decript
let m_d = power(c, d, N);
console.log(m_d);
// prepare message for encode and encode
let enc = new TextEncoder();
let chat_message = "Yö ha!";

let coded_message = Array.from(enc.encode(chat_message));

for (i in coded_message) {
    //add pad to message 
    let padd = "" + pad_seperator + nBitRandom(8);
    coded_message[i] = BigInt("" + coded_message[i] + padd);
    //encrypt
    coded_message[i] = power(coded_message[i], e, N);
    //decrypt
    coded_message[i] = power(coded_message[i], d, N);
    //remove padding
    coded_message[i] = Number(coded_message[i].toString().split(pad_seperator)[0]);

}

let dec = new TextDecoder("utf-8");

let decoded_message = dec.decode(Uint8Array.from(coded_message));
console.log(decoded_message);
