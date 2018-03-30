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

	//�����ӽ���1 child1 process
	pid1 = fork();
	
	//���ڸ����� �򴴽� �ӽ���2
	//�����ӽ��� �򴴽� �ӽ���1-->�ӽ���2 ������̣� 
	pid2 = fork();	
	 
	 //������ �ӽ���1 �ӽ���2 ����� ��pid2�Ľ����ж� 
	switch(pid2){
		case 0://�ӽ���2 �� �����	
			child2();
			break;
		case -1: //���̴��� 
			tprintf("error\n");
			break;
		default: //�����̻��ӽ���1  ����pid1�Ľ����ж� 
			swtichForPid1(pid1,pid2);
			break; 
	} 
	
	return 0;
}

//�ӽ���1�����  10 11 12 ���� 
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

//2�Ž��̵���� 0 1 2 ���� 
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

//��pid2�Ľ����ж�
void swtichForPid2(pid_t pid2){
		switch(pid2){
	
			case 0: //�ӽ���2 child2 process
				//ִ���ӽ���2����� 
				child2();
				break;
			case -1://�����쳣 
				tprintf("everythign done\n");
				break;
		default://������ parent
		    //���������̴������ӽ���2 
			tprintf("parent forked child2,call c2-- %d\n",pid2);
			//�ȴ��ӽ���2ִ�н���	
			tprintf("parent waiting child2\n");
			waitpid(pid2,NULL,0);
			tprintf("child2 has exited\n");	
			break;		

	}
}
void swtichForPid1(int pid1,int pid2){
	
	//������ �ӽ���1  ��pid1�Ľ����ж� 
	switch(pid1){
		case 0://�ӽ���1 child1 process
		// ������������� 
		tprintf("child1 forked child1->child2, call c1c2 -- %d\n",pid2);
		//ִ���ӽ���1����� 
		child1();
		//������� = �ӽ���1->�ӽ���2 ִ�� 
			tprintf("child1 waiting c1c2\n");
			waitpid(pid2,NULL,0);
			tprintf("c1c2 has exited\n");
			break;
		
		case -1: //���̴��� 
			tprintf("error\n");
			break;
		
		default:
			//������ parent
			//�������״������ӽ���1 
			tprintf("parent forked child1,call c1-- %d\n",pid1);
			
			//������� �Ѷ��ӽ���2 pid2�Ľ����жϵ�������� 
            swtichForPid2(pid2);
			//���ӽ���1ִ�� 
			tprintf("parent waiting child1\n");
			waitpid(pid1,NULL,0);
			tprintf("child1 has exited\n");
				
			//���� 
			tprintf("parent has exited \n");
	}
} 
//������� 
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
