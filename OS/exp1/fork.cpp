#include <stdlib.h>
#include <stdio.h>
#include <time.h>

#include <unistd.h>
#include <stdarg.h>
#include <sys/types.h>
#include <sys/wait.h>

/* run this program using the console pauser or add your own getch, system("pause") or input loop */

int tprintf(const char*fmt,...);

int main(void) {
	
	int i=0,j=0;
	int pid;
	printf("a Parent Process,PID = %d \n",getpid());
	
	pid = fork();
	if(pid==0){ // child 1 process
		sleep(1);
		for(i=0;i<3;i++){
			printf("child 1 process %d exc %d times \n",getpid(),i+1);
			sleep(1);
		}
	}else if(pid !=1){ // parent process
		tprintf("Parent forked one child process --%d\n",pid);
		tprintf("Parent waiting child\n");
		waitpid(pid,NULL,0);
		tprintf("chile had exited \n");
		tprintf("Parent exited\n");
	}else{
		tprintf("everything done\n");
	}	
	return 0;
}

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
