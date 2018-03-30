#include <unistd.h>
#include <stdarg.h>
#include <time.h>
#include <sys/types.h>
#include <sys/wait.h>
#include <stdio.h>
#include <stdlib.h>
/* run this program using the console pauser or add your own getch, system("pause") or input loop */

int tprintf(const char*fmt,...);
void child1();
void child2();
void swtichForPid1( int pid1,int pid2);
void swtichForPid2( pid_t pid2);
	
int main(void) {
	pid_t pid1,pid2,pid3;

	//创建子进程1 child1 process
	pid1 = fork();
	
	//若在父进程 则创建 子进程2
	//若在子进程 则创建 子进程1-->子进程2 （孙进程） 
	pid2 = fork();	
	 
	 //父进程 子进程1 子进程2 孙进程 对pid2的进程判断 
	switch(pid2){
		case 0://子进程2 或 孙进程	
			child2();
			break;
		case -1: //进程错误 
			tprintf("error\n");
			break;
		default: //父进程或子进程1  进行pid1的进程判断 
			swtichForPid1(pid1,pid2);
			break; 
	} 
	
	return 0;
}

//子进程1的输出  10 11 12 计数 
void child1(void){
		int num;	
		sleep(1);
		tprintf("hello from child 1\n");
		sleep(1);
		tprintf("c1 do something \n");
		for(num = 10;num<13;num++){
			tprintf("c1 counting: %d\n",num);
			sleep(3);
		}
		tprintf("child1 is counting over\n");
}

//2号进程的输出 0 1 2 计数 
void child2(void){
		int num ;
		sleep(1);
		tprintf("hello from child 2 ,maybe is c2 or c1c2 \n");
		sleep(1);
		tprintf("(c2 || c1c2) do something \n");
		for(num = 0;num<3;num++){
			tprintf("(c2 || c1c2) counting: %d\n",num);
			sleep(3);
		}
		tprintf("child2 is counting over\n");
}

//对pid2的进程判断
void swtichForPid2(pid_t pid2){
		switch(pid2){
	
			case 0: //子进程2 child2 process
				//执行子进程2的输出 
				child2();
				break;
			case -1://进程异常 
				tprintf("everythign done\n");
				break;
		default://父进程 parent
		    //声明父进程创建了子进程2 
			tprintf("parent forked child2,call c2-- %d\n",pid2);
			//等待子进程2执行结束	
			tprintf("parent waiting child2\n");
			waitpid(pid2,NULL,0);
			tprintf("child2 has exited\n");	
			break;		

	}
}
void swtichForPid1(int pid1,int pid2){
	
	//父进程 子进程1  对pid1的进程判断 
	switch(pid1){
		case 0://子进程1 child1 process
		// 声明传建孙进程 
		tprintf("child1 forked child1->child2, call c1c2 -- %d\n",pid2);
		//执行子进程1的输出 
		child1();
		//等孙进程 = 子进程1->子进程2 执行 
			tprintf("child1 waiting c1c2\n");
			waitpid(pid2,NULL,0);
			tprintf("c1c2 has exited\n");
			break;
		
		case -1: //进程错误 
			tprintf("error\n");
			break;
		
		default:
			//父进程 parent
			//声明父亲创建了子进程1 
			tprintf("parent forked child1,call c1-- %d\n",pid1);
			
			//避免混淆 把对子进程2 pid2的进程判断单独抽出来 
            swtichForPid2(pid2);
			//等子进程1执行 
			tprintf("parent waiting child1\n");
			waitpid(pid1,NULL,0);
			tprintf("child1 has exited\n");
				
			//结束 
			tprintf("parent has exited \n");
	}
} 
//代码输出 
int tprintf(const char*fmt,...){
	va_list args;
	struct tm *tstruct;
	time_t tsec;
	tsec = time(NULL) ;
	tstruct = localtime(&tsec);
	printf("%02d:%02d:%02d |%5d|",tstruct->tm_hour,tstruct->tm_min,tstruct->tm_sec,getpid() );
	va_start(args,fmt);
	return vprintf(fmt,args);
}
